<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Remove white background and convert to PNG.
     */
    public static function removeBackgroundAndConvertToPng($imagePath, $tolerance = 30)
    {
        try {
            $fullPath = Storage::disk('public')->path($imagePath);
            
            // Get image info
            $imageInfo = getimagesize($fullPath);
            if (!$imageInfo) {
                return $imagePath; // Return original if not an image
            }

            $width = $imageInfo[0];
            $height = $imageInfo[1];
            $mimeType = $imageInfo['mime'];

            // Create image resource based on type
            switch ($mimeType) {
                case 'image/jpeg':
                    $source = imagecreatefromjpeg($fullPath);
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($fullPath);
                    break;
                case 'image/gif':
                    $source = imagecreatefromgif($fullPath);
                    break;
                default:
                    return $imagePath; // Return original if unsupported
            }

            if (!$source) {
                return $imagePath;
            }

            // Create new image with transparency
            $newImage = imagecreatetruecolor($width, $height);
            
            // Enable alpha blending and save alpha
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            
            // Fill with transparent background
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefill($newImage, 0, 0, $transparent);

            // Process each pixel
            for ($x = 0; $x < $width; $x++) {
                for ($y = 0; $y < $height; $y++) {
                    $rgb = imagecolorat($source, $x, $y);
                    $r = ($rgb >> 16) & 0xFF;
                    $g = ($rgb >> 8) & 0xFF;
                    $b = $rgb & 0xFF;
                    $a = ($rgb >> 24) & 0x7F;

                    // Check if pixel is white/light (within tolerance)
                    // Also check if it's already transparent
                    $isWhite = ($r > 255 - $tolerance && $g > 255 - $tolerance && $b > 255 - $tolerance);
                    $isTransparent = ($a > 100); // Already has transparency
                    
                    if ($isWhite && !$isTransparent) {
                        // Make transparent
                        $color = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                    } else {
                        // Keep original color with proper alpha
                        if ($isTransparent) {
                            // Preserve existing transparency
                            $color = imagecolorallocatealpha($newImage, $r, $g, $b, $a);
                        } else {
                            // Opaque pixel
                            $color = imagecolorallocatealpha($newImage, $r, $g, $b, 0);
                        }
                    }
                    
                    imagesetpixel($newImage, $x, $y, $color);
                }
            }

            // Generate new filename with .png extension
            $pathInfo = pathinfo($imagePath);
            $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.png';

            // Save as PNG
            imagepng($newImage, Storage::disk('public')->path($newPath), 9);

            // Clean up
            imagedestroy($source);
            imagedestroy($newImage);

            // Delete old file if it's not already PNG
            if ($pathInfo['extension'] !== 'png') {
                Storage::disk('public')->delete($imagePath);
            }

            return $newPath;
        } catch (\Exception $e) {
            // If processing fails, return original
            return $imagePath;
        }
    }

    /**
     * Simple background removal - removes white/light backgrounds.
     */
    public static function removeWhiteBackground($imagePath)
    {
        return self::removeBackgroundAndConvertToPng($imagePath, 30);
    }
}

<?php

namespace App\Helpers;

use App\Models\Product;
use App\Models\User;

class WhatsAppHelper
{
    /**
     * Generate WhatsApp URL for product inquiry.
     */
    public static function generateProductInquiryUrl(Product $product, $quantity = 1, $customMessage = null)
    {
        $seller = $product->user;
        
        if (!$seller->whatsapp_number) {
            return null;
        }

        // Clean the phone number (remove non-numeric characters except +)
        $phoneNumber = self::cleanPhoneNumber($seller->whatsapp_number);
        
        // Generate the message
        $message = $customMessage ?: self::generateProductInquiryMessage($product, $quantity);
        
        // Encode the message for URL
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
    }

    /**
     * Generate WhatsApp URL for general contact.
     */
    public static function generateContactUrl(User $user, $message = null)
    {
        if (!$user->whatsapp_number) {
            return null;
        }

        $phoneNumber = self::cleanPhoneNumber($user->whatsapp_number);
        $defaultMessage = "Hi! I found your contact through the Local Marketplace.";
        $finalMessage = $message ?: $defaultMessage;
        $encodedMessage = urlencode($finalMessage);
        
        return "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
    }

    /**
     * Generate a product inquiry message.
     */
    private static function generateProductInquiryMessage(Product $product, $quantity = 1)
    {
        $message = "Hi! I'm interested in your product:\n\n";
        $message .= "📦 Product: {$product->name}\n";
        $message .= "🆔 Product ID: {$product->id}\n";
        $message .= "💰 Price: {$product->formatted_price}\n";
        $message .= "📊 Quantity: {$quantity}\n";
        
        if ($quantity > 1) {
            $totalPrice = $product->price * $quantity;
            $message .= "💵 Total: $" . number_format($totalPrice, 2) . "\n";
        }
        
        $message .= "\nCould you please provide more details about availability and delivery options?\n\n";
        $message .= "Thank you!";
        
        return $message;
    }

    /**
     * Clean phone number for WhatsApp URL.
     */
    private static function cleanPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters except +
        $cleaned = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // If it starts with +, keep it, otherwise assume it needs country code
        if (!str_starts_with($cleaned, '+')) {
            // If it's a US number (10 digits), add +1
            if (strlen($cleaned) === 10) {
                $cleaned = '+1' . $cleaned;
            }
            // For other cases, you might want to add logic for different country codes
        }
        
        return $cleaned;
    }

    /**
     * Validate WhatsApp number format.
     */
    public static function isValidWhatsAppNumber($phoneNumber)
    {
        if (empty($phoneNumber)) {
            return false;
        }
        
        $cleaned = self::cleanPhoneNumber($phoneNumber);
        
        // Basic validation: should start with + and have at least 10 digits
        return preg_match('/^\+[1-9]\d{9,14}$/', $cleaned);
    }

    /**
     * Format WhatsApp number for display.
     */
    public static function formatWhatsAppNumber($phoneNumber)
    {
        $cleaned = self::cleanPhoneNumber($phoneNumber);
        
        // Format for display (you can customize this based on your needs)
        if (str_starts_with($cleaned, '+1') && strlen($cleaned) === 12) {
            // US number format: +1 (XXX) XXX-XXXX
            return '+1 (' . substr($cleaned, 2, 3) . ') ' . substr($cleaned, 5, 3) . '-' . substr($cleaned, 8, 4);
        }
        
        return $cleaned; // Return as-is for other formats
    }

    /**
     * Generate WhatsApp URL for order confirmation.
     */
    public static function generateOrderConfirmationUrl(Product $product, $orderDetails)
    {
        $seller = $product->user;
        
        if (!$seller->whatsapp_number) {
            return null;
        }

        $phoneNumber = self::cleanPhoneNumber($seller->whatsapp_number);
        
        $message = "🛒 Order Confirmation\n\n";
        $message .= "📦 Product: {$product->name}\n";
        $message .= "🆔 Order ID: {$orderDetails['order_id']}\n";
        $message .= "📊 Quantity: {$orderDetails['quantity']}\n";
        $message .= "💰 Total: {$orderDetails['total']}\n";
        $message .= "📅 Order Date: {$orderDetails['date']}\n\n";
        $message .= "Please confirm this order and let me know about delivery arrangements.\n\n";
        $message .= "Thank you!";
        
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
    }
}

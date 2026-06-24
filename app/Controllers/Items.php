<?php
namespace App\Controllers;

/**
 * Legacy proxy controller for OSPOS backward compatibility.
 * Safely routes all 'items' endpoint hits natively to the 'Products' controller.
 */
class Items extends Products
{
}

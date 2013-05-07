<?php
require_once('classes/MAW.php');

function maw_currentUser()
{
    $context = MAW::getContext();
    return $context->getCurrentUser();
}

function maw_otherUsers()
{
    $context = MAW::getContext();
    return $context->getOtherUsers();
}

function maw_colors()
{
    $context = MAW::getContext();
    return $context->getColors();
}

function maw_categories()
{
    $context = MAW::getContext();
    return $context->getCategories();
}

?>
<?php

/*
 * Library configuration settings.
 */

/*
 * If true, the autoloader won't generate a fatal error if the class cannot
 * be loaded.
 *
 * Other libraries can then install their own auto loaders and try to find
 * the class file to load.
 */
$config['autoload-chain'] = true;

// List of all the intercepting filters classes.
$config['intercepting-filters'] = ['Session'];
<?php

  // Instantiate Silex
  $app = new Silex\Application();

  // Include Twig with Silex app
  $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__."/../../views"
  ));

  // Allow use of http protocols beyond get and post
  use Symfony\Component\HttpFoundation\Request;
  Request::enableHttpMethodParameterOverride();

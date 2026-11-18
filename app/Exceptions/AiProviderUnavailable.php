<?php

namespace App\Exceptions;

use Exception;

/** The provider cannot serve requests right now, so retrying it would only use up free quota. */
class AiProviderUnavailable extends Exception {}

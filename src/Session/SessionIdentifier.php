<?php

namespace Oak\Session;

use app\session\contracts\SessionIdentifierInterface;

class SessionIdentifier implements SessionIdentifierInterface
{
	public function generate(int $length): string
	{
		$string = '';
		while (($len = strlen($string)) < $length) {
			$size = $length - $len;
			$bytes = random_bytes($size);
			$string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
		}
		return $string;
	}
}
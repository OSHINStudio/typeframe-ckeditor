<?php
/*
 * Generate a stylesheet that emulates the design of the content being
 * edited.
 */
header('Content-type: text/css');
$stylesheets = json_decode($_REQUEST['stylesheets']);
$selectors = explode(' ', $_REQUEST['selector']);
$base = '';
$output = '';
$less = new lessc();
if ( (is_array($stylesheets)) && (count($stylesheets)) ) {
	foreach ($stylesheets as $s) {
		$extension = pathinfo($s, PATHINFO_EXTENSION);
		if ($extension == strtolower('less')) {
			$cur = $less->parse(file_get_contents(TYPEF_DIR . substr($s, strlen(TYPEF_WEB_DIR)))) . "\n";
			$cur = SimpleCss::LoadString($cur, dirname($s))->toString();
			$base .= $cur;
		} else {
			$cur = file_get_contents(TYPEF_DIR . substr($s, strlen(TYPEF_WEB_DIR))) . "\n";
			$cur = SimpleCss::LoadString($cur, dirname($s))->toString();
			$base .= $cur;
		}
	}
	$output = $base;
	$output = "/* SELECTOR: {$_REQUEST['selector']} */\n\n" . $output;
	// Find rules that affect the provided selector's content and apply them to
	// the editor's body.
	$css = SimpleCss::LoadString($base);
	foreach ($css->Stylerulesets() as $ruleset) {
		foreach($ruleset->selectors() as $selector) {
			$target = $selectors;
			$parts = explode(' ', $selector);
			$cur = count($parts);
			$match = true;
			while ( (count($target)) && (count($parts)) ) {
				if ($target[0] != $parts[0]) {
					$match = false;
					if ( (substr($parts[0], 0, 1) == '#') || ((substr($parts[0], 0, 1) == '.')) ) {
						if (strpos($target[0], $parts[0]) !== false) {
							$match = true;
							array_shift($parts);
						}
					}
				} else {
					$match = true;
					array_shift($parts);
				}
				array_shift($target);
			}
			if (count($parts)) {
				if (count($parts) < $cur) {
					$output .= "/* MATCH TO CONTENT: " . implode(' ', $parts) . " */\n";
					if ($parts[0] == '>') {
						array_unshift($parts, 'body');
					}
					$output .= implode(' ', $parts) . " {\n" . $ruleset->rules() . "\n}\n";
				}
			} else {
				$output .= "/* MATCH TO BODY: " . $selector . " */\n";
				$output .= "body {\n" . $ruleset->rules() . "\n}\n";
			}
		}
	}
}
echo $output;
exit;

<?php

/*
 * BP Profile Search - filters template 'bps-filters'
 *
 * See http://dontdream.it/bp-profile-search/form-templates/ if you wish to modify this template or develop a new one.
 *
 */

	$F = bps_escaped_filters_data ();
	$filters = '';

	foreach ($F->fields as $f)
	{
		switch ($f->display)
		{
		case 'range':
			if ($f->min === '' && $f->max === '')  break;
			$filters .= "<strong>$f->label:</strong>";
			if ($f->min !== '')
				$filters .= " <strong>". __('min', 'social-portal'). "</strong> $f->min";
			if ($f->max !== '')
				$filters .= " <strong>". __('max', 'social-portal'). "</strong> $f->max";
			$filters .= "<br>\n";
			break;

		case 'hidden':
			break;

		case 'textbox':
		case 'number':
		case 'textarea':
		case 'url':
			if ($f->value === '')  break;
			$filters .= "<strong>$f->label:</strong> $f->value<br>\n";
			break;

		case 'selectbox':
		case 'radio':
		case 'multiselectbox':
		case 'checkbox':
			$values = array ();
			foreach ($f->options as $key => $label)
				if (in_array ($key, $f->values))  $values[] = $label;
			$values = implode (', ', $values);
			if ($values === '')  break;
			$filters .= "<strong>$f->label:</strong> $values<br>\n";
			break;

		default:
			$filters .= "<p>" . sprintf( __( "BP-Profilsuche: Du kannst den Filtertyp <em>%s</em> nicht anzeigen.", 'social-portal' ), $f->display ) . "</p>\n";
			break;
		}
	}

	if ($filters)
	{
		$action = parse_url ($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		echo "<p class='bps_filters'>\n";
		echo $filters;
		echo "<a href='$action' class='btn btn-clear btn-bps-clear'>". __( 'Leeren', 'social-portal' ) . "</a><br>\n";
		echo "</p>\n";
	}

// BP Profile Search - end of template

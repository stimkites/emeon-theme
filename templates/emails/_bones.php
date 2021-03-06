<?php

/**
 * Template Name: Email notification template
 *
 * @global string $title        Email subject/title
 * @global string $subtitle     Subtitle if needed
 * @global string $content      Email content
 */

/** @var WP_User $user */

ob_start();

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="initial-scale=1.0">
	<title>EMEON - employ me online!</title>
	<style>
		body {
			margin: 0;
			padding: 0;
		}

		img {
			border: 0;
			display: block;
		}

		.socialLinks {
			font-size: 9px;
		}

		.socialLinks a {
			display: inline-block;
		}

		.long-text p {
			margin: 1em 0;
		}

		.long-text p:last-child {
			margin-bottom: 0;
		}

		.long-text p:first-child {
			margin-top: 0;
		}
	</style>
	<style>
		/* yahoo, hotmail */
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font,
		.ExternalClass td, .ExternalClass div {
			line-height: 100%;
		}

		.yshortcuts a {
			border-bottom: none !important;
		}

		.vb-outer {
			min-width: 0 !important;
		}

		.RMsgBdy, .ExternalClass {
			width: 100%;
			background-color: #3f3f3f;
		}

		/* outlook/office365 add buttons outside not-linked images and safari have 2px margin */
		[o365] button {
			margin: 0 !important;
		}

		/* outlook */
		table {
			mso-table-rspace: 0;
			mso-table-lspace: 0;
		}

		#outlook a {
			padding: 0;
		}

		img {
			outline: none;
			text-decoration: none;
			border: none;
			-ms-interpolation-mode: bicubic;
		}

		a img {
			border: none;
		}

		@media screen and (max-width: 600px) {
			table.vb-container, table.vb-row {
				width: 95% !important;
			}

			.mobile-hide {
				display: none !important;
			}

			.mobile-textcenter {
				text-align: center !important;
			}

			.mobile-full {
				width: 100% !important;
				max-width: none !important;
			}
		}

		/* previously used also screen and (max-device-width: 600px) but Yahoo Mail doesn't support multiple queries */
	</style>
	<style>

		#ko_sideArticleBlock_4 .links-color a, #ko_sideArticleBlock_4 .links-color a:link,
		#ko_sideArticleBlock_4 .links-color a:visited, #ko_sideArticleBlock_4 .links-color a:hover {
			color: #3f3f3f;
			text-decoration: underline
		}

		#ko_footerBlock_2 .links-color a, #ko_footerBlock_2 .links-color a:link,
		#ko_footerBlock_2 .links-color a:visited,
		#ko_footerBlock_2 .links-color a:hover {
			color: #cccccc;
			text-decoration: underline
		}
	</style>

</head>
<!--[if !(gte mso 16)]-->
<body bgcolor="#ffffff" text="#919191" alink="#cccccc" vlink="#cccccc"
      style="margin: 0; padding: 0; background-color: #ffffff; color: #919191;"><!--<![endif]-->
<center>

	<table role="presentation" class="vb-outer" width="100%" cellpadding="0" border="0" cellspacing="0"
	       bgcolor="#ffffff" style="background-color: #ffffff;" id="ko_sideArticleBlock_4">
		<tbody>
		<tr>
			<td class="vb-outer" align="center" valign="top"
			    style="padding-left: 9px; padding-right: 9px; font-size: 0;">
				<!--[if (gte mso 9)|(lte ie 8)]>
				<table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0" width="570">
					<tr>
						<td align="center" valign="top"><![endif]--><!--
      -->
				<div style="margin: 0 auto; max-width: 570px; -mru-width: 0px;">
					<table role="presentation" border="0" cellpadding="0" cellspacing="9" bgcolor="#ffffff" width="570"
					       class="vb-row"
					       style="border-collapse: separate; width: 100%; background-color: #ffffff; mso-cellspacing: 9px; border-spacing: 9px; max-width: 570px; -mru-width: 0px;">

						<tbody>
						<tr>
							<td align="center" valign="top" style="font-size: 0;">
								<div style="width: 100%; max-width: 552px; -mru-width: 0px;">
									<!--[if (gte mso 9)|(lte ie 8)]>
									<table role="presentation" align="center" border="0" cellspacing="0" cellpadding="0"
									       width="552">
										<tr><![endif]--><!--
        --><!--
          --><!--[if (gte mso 9)|(lte ie 8)]>
									<td align="left" valign="top" width="184"><![endif]--><!--
      -->
									<div class="mobile-full"
									     style="display: inline-block; vertical-align: top; width: 100%; max-width: 184px; -mru-width: 0px; min-width: calc(33.333333333333336%); max-width: calc(100%); width: calc(304704px - 55200%);"><!--
        -->
										<table role="presentation" class="vb-content" border="0" cellspacing="9"
										       cellpadding="0" width="184" align="left"
										       style="border-collapse: separate; width: 100%; mso-cellspacing: 9px; border-spacing: 9px; -yandex-p: calc(2px - 3%);">

											<tbody>
											<tr>
												<td width="100%" valign="top" align="center" class="links-color">
													<!--[if (lte ie 8)]>
													<div style="display: inline-block; width: 166px; -mru-width: 0px;">
													<![endif]--><img border="0" hspace="0" align="center" vspace="0"
													                 width="166"
													                 style="border: 0px; display: block; vertical-align: top; height: auto; margin: 0 auto; color: #3f3f3f; font-size: 13px; font-family: Arial, Helvetica, sans-serif; width: 100%; max-width: 166px; height: auto;"
													                 src="<?=site_url(
									                    '/wp-content/themes/emeon-theme/img/emeon-logo-2-small.png'
													                 )?>">
													<!--[if (lte ie 8)]></div><![endif]--></td>
											</tr>

											</tbody>
										</table><!--
      --></div>
									<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]--><!--
          --><!--[if (gte mso 9)|(lte ie 8)]>
									<td align="left" valign="top" width="368"><![endif]--><!--
      -->
									<div class="mobile-full"
									     style="display: inline-block; vertical-align: top; width: 100%; max-width: 368px; -mru-width: 0px; min-width: calc(66.66666666666667%); max-width: calc(100%); width: calc(304704px - 55200%);"><!--
        -->
										<table role="presentation" class="vb-content" border="0" cellspacing="9"
										       cellpadding="0" width="368" align="left"
										       style="border-collapse: separate; width: 100%; mso-cellspacing: 9px; border-spacing: 9px; -yandex-p: calc(2px - 3%);">

											<tbody>
											<tr>
												<td width="100%" valign="top" align="left"
												    style="font-weight: normal; color: #3f3f3f; font-size: 18px; font-family: Arial, Helvetica, sans-serif; text-align: left;">
													<h1 style="font-weight: normal;">
														<?=$title?>
													</h1>
													<h3 style="font-size:80%">
														<?=$subtitle?>
													</h3>
												</td>
											</tr>
											<tr>
												<td class="long-text links-color" width="100%" valign="top" align="left"
												    style="font-weight: normal; color: #3f3f3f; font-size: 14px; font-family: Arial, Helvetica, sans-serif; text-align: left; line-height: normal;">
													<p style="margin: 1em 0px; margin-bottom: 0px; margin-top: 0px;">
														<?=$content?>
													</p>
												</td>
											</tr>

											<tr>
												<td class="long-text links-color" width="100%" valign="top"
												    align="right"
												    style="font-weight: normal; color: #3f3f3f; font-size: 10px; font-family: Arial, Helvetica, sans-serif; text-align: right; line-height: normal; padding-top: 20px;">&copy; EMEON, 2016 - <?php echo date( 'Y' ); ?>
													<span class="sep"> | </span>
													By Emeon partner, <a href="https://wetail.io">Wetail AB, Sweden</a>
												</td>
											</tr>
											</tbody>
										</table><!--
                                    --></div>
									<!--[if (gte mso 9)|(lte ie 8)]></td><![endif]--><!--
          --><!--
        --><!--
      --><!--[if (gte mso 9)|(lte ie 8)]></tr></table><![endif]--></div>
							</td>
						</tr>

						</tbody>
					</table>
				</div><!--
    --><!--[if (gte mso 9)|(lte ie 8)]></td></tr></table><![endif]-->
			</td>
		</tr>
		</tbody>
	</table>

</center><!--[if !(gte mso 16)]--></body><!--<![endif]--></html>

<?php

$html = ob_get_clean();

return wp_mail(
	$user->user_email, $title, $html, [ "Reply-To: support@emeon.io", "Content-Type: text/html; charset=UTF-8" ]
);

{$xml}
{$docType}
<title>{$siteName}</title>
<meta http-equiv="Content-Type" content="{$contentType} charset=utf-8" />
<meta http-equiv="Content-Language" content="ja" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="keywords" content="{$keywords}" />
<meta name="description" content="{$description}" />
<meta name="copyright" content="{$copyright}" />
<meta name="author" content="{$siteName}" />
{*<meta name="robots" content="noindex,nofollow" />*}
<link rel="start" href="index.php" title="{$siteName}" />
<link rel="shortcut icon" type="image/x-icon"  href="img/ko-haito_favicon.ico" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="index.xml" />
<link rel="alternate" media="handheld" href="{$config.define.SITE_URL}" />
<link rev="made" href="mailto:info@{$config.define.MAIL_DOMAIN}" />
<link rel="stylesheet" href="css/import.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/swfobject.js"></script>
<!--[if lte IE 6]>
<script type="text/javascript" src="./js/DD_belatedPNG_0.0.7a.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('.transparent');
</script>
<![endif]-->
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="msvalidate.01" content="02FB98501843AAF10D6D549E01CB6A61" />
    <link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.png" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<script type="application/ld+json">
		[{
			"@context": "https://schema.org",
			"@type": "LocalBusiness",
			"name": "DocuVault Delaware Valley",
			"address": {
				"@type": "PostalAddress",
				"streetAddress": "1395 Imperial Way",
				"addressLocality": "West Deptford",
				"addressRegion": "NJ",
				"addressCountry": "US",
				"postalCode": "08066"
			},
			"openingHours": [
				"Mo-Fr 9:00-17:00",
				"Sa-Su Closed"
			],
			"telephone": "856-209-4713",
			"url": "https://docuvaultdv.com",
			"image" : "https://docuvaultdv.com/wp-content/themes/docuvault/img/logo.png"
		},
		{
			"@context": "https://schema.org",
			"@type": "Organization",
			"url": "https://docuvaultdv.com",
			"sameAs" : [ 
				"https://www.facebook.com/DocuVault-Delaware-Valley-LLC-142445592435008/",
				"https://twitter.com/DocuVaultDV",
				"https://www.linkedin.com/company/984618/"
			],
			"logo" : "https://docuvaultdv.com/wp-content/themes/docuvault/img/logo.png",
			"contactPoint" : [{
				"@type" : "ContactPoint",
				"telephone" : "+1-856-853-5160",
				"contactType" : "customer service"
			
			},
			{
				"@type" : "ContactPoint",
				"telephone" : "+1-856-290-4601",
				"contactType" : "sales"
			
			}]
		}]
	</script>
    <?php wp_head(); ?>
	<script>
		dataLayer = [{
			'form_submitted': 'none'
		}];
	 </script>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-T4TJHKB');</script>
<!-- Google Tag Manager -->

</head>
<meta name="msvalidate.01" content="F217D0EFEF0ECA9ECE9FB50F7D17A54F" />
<body <?php body_class(); ?>>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T4TJHKB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


<header class="site-header">
    <div id="flexHeader" class="container flex-header padding0">

        <div class="logo"><a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="" width="370"></a></div>

        <div class="header-block">
            <div class="phone">
                <p class="salesnum"><span>Sales:</span><a href="tel:18562904601">856-290-4601</a></p>
                <p><span>Customer Service:</span><a href="tel:8568535160">856-853-5160</a></p>
            </div>
        </div>

    </div>

    <div class="header-nav">
        <div class="container padding0">
          <div class="stickylogo"><a href="<?php echo home_url(); ?>"><img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="" width="370"></a></div>
            <div class="mobile-icons">
                <a href="tel:18562904601" class="nav-phone">
                    <i class="fa fa-phone"></i>
                    <span>CALL</span>
                </a>

                <a href="<?php echo home_url(); ?>/contact/" class="nav-contact">
                    <i class="fa fa-envelope"></i>
                    <span>CONTACT</span>
                </a>

                <a href="javascript:void(0);" id="navToggle" class="nav-toggle">
                    <i class="fa fa-bars"></i>
                    <span>MENU</span>
                </a>
            </div>
            <nav id="mainNav" class="mobile-nav" role="navigation">
               <?php wp_nav_menu( array( 'theme_location' => 'main-menu', 'container' => '' ) ); ?>
            </nav>
        </div>
    </div>
</header>

<main>

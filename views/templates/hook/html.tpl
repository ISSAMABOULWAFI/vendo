{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
*}

<div id="mymodule_block_home" class="block">

<script>
  
  {literal}
(function(v,e,n,d,o,m,a){
		  v.vndo=v.vndo||function(x,y){(v.vndo.q=v.vndo.q||[]).push({x:x,y:y})};
		  o=e.getElementsByTagName('head')[0];m=e.createElement('script');
          m.async=1;m.src=n+'/tracking.js?aid='+d;o.appendChild(m);v.vndo.d=n;
		})(window,document,{/literal}"{Configuration::get('Vendo-TrackingUrl')|escape:'htmlall':'UTF-8'}"{literal},{/literal} "{Configuration::get('Vendo-storeId')|escape:'htmlall':'UTF-8'}" {literal});
    {/literal}
    {if Configuration::get("Vendo-CpsEnabled") == 1 && Configuration::get("Vendo-ViewPage") =="true" }
      {literal}
      vndo("ViewPage",{contentId: {/literal} ""   {literal}})
      {/literal}
    {/if}


</script>

{*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
*}

<html>
<script>
{if Configuration::get("Vendo-CpsEnabled") == 1  }
      {literal}
      vndo("Order",{id: {/literal} "{$order_id|escape:'htmlall':'UTF-8'}" {literal}, currency: {/literal} "{$currency->name|escape:'htmlall':'UTF-8'}" {literal}})
      {/literal}
{/if}
</script>
</html>
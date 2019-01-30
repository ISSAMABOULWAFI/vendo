
{*
    * 2007-2016 PrestaShop
    *
    * NOTICE OF LICENSE
    * This source file is subject to the Academic Free License (AFL 3.0)
    * that is bundled with this package in the file LICENSE.txt.
    *}
    
<html>

    <link rel="stylesheet" type="text/css" href="{$folder|escape:'htmlall':'UTF-8'}/views/css/style.css">
    <form id="vendoLinkerMainView"
     action="index.php?controller=AdminModules&configure=vendo&token={Tools::getAdminTokenLite('AdminModules')|escape:'htmlall':'UTF-8'}"
     method="post" enctype="multipart/form-data">
        <input type="hidden" name="submitvendo" value="1">
        <div id="vendoLogo">
            <img src="{$folder|escape:'htmlall':'UTF-8'}/views/img/logo.svg" width="93">
            
        </div>
        {if Configuration::get('Vendo-CpsEnabled') == false }
            <div id="intro" class="withIcon">
                <h3>Boostez la visibilité de vos produits grâce à Vendo Plus !</h3>
                <p>
                   Vos produits qui convertissent le mieuxseront automatiquement mis en avant des résultats de recherches adéquates.
                </p>
                <img src="{$folder|escape:'htmlall':'UTF-8'}/views/img/cps-icon.svg" class="icon">
                <a target="_blank" href="https://business.vendo.ma/affiliation" class="btn red">Plus d'informations</a>
            </div>
        {else}
            <div id="intro" class="withIcon">
                <h3>Suivez la performance de vos produits !</h3>
                <p>
                    Vous pouvez visualiser les statistiques relatives à la performance de votre site à partir de votre tableau de bord.
                </p>
                <img src="{$folder|escape:'htmlall':'UTF-8'}/views/img/stats-icon.svg" class="icon-bis">
                <a target="_blank" href="https://business.vendo.ma/app" class="btn stroke">Voir les statistiques</a>
            </div>
        {/if}
        <div id="TokenDiv">
            <div class="underline">
                <span  class="text"> Your Token : </span>
                <span  id="token">
                        <span id="tokenTxt">{Configuration::get("Vendo-TOKEN")|escape:'htmlall':'UTF-8'}
                        </span>
                        <span id="copy"><img src="{$folder|escape:'htmlall':'UTF-8'}/views/img/arrow.png" alt="" > 
                            <span id="copyTxt" >Copy
                            </span> 
                        </span>
                </span>
            </div>
        </div>
        {if Configuration::get('Vendo-CpsEnabled') == false}
            <div></div>
        {else }   
            <div id="options">
                <h3>Tracking d'événements</h3>
                <ul>
                    <li>
                        <span class="trackingOption text">
                            <label class="vendoSwitch">
                                <input type="checkbox" checked="checked" disabled value="true">
                                <span class="notAllowed vendoSlider v-round"></span>
                            </label>
                            <span>Commandes</span>

                        </span>
                    </li>
                    <li>
                        <span  class="trackingOption text">
                            <label class="vendoSwitch">
                                {if Configuration::get("Vendo-ViewPage") == true  }
                                    <input type="checkbox" checked = "checked"
                                    id="viewPageCheckBox" name="Vendo-ViewPage" value="true">
                                {else}
                                    <input type="checkbox" 
                                    id="viewPageCheckBox" name="Vendo-ViewPage" value="true">
                                {/if}
                                <span class="vendoSlider v-round"></span>
                            </label>
                            <span>Pages vues</span>
                        </span>
                    </li>
                </ul>

                <button id="saveButton" class="btn" type="submit" value="1" name="submitvendo">Sauvegarder</button>
                <div class="clearfix"></div>
            </div> 
        {/if}
    </form>
    <script src="{$folder|escape:'htmlall':'UTF-8'}/views/js/script.js"></script>
</html>
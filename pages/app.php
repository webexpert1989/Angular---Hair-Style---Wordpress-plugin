<?php
/**************************************************************
 *
 * template to generate Hair App
 *
 **************************************************************/


function emptyObj($obj) {
    foreach ($obj as $k) {
        return false;
    }
    return true;
}

function H_app($data = object){

    if(emptyObj($data)){
        echo "No Data";
        return false;
    }
    
	/////////////
	$data->hair_colors = stripslashes(base64_decode($data->hair_colors));
    $data->hair_maingroup = stripslashes(base64_decode($data->hair_maingroup));

	///////////

	?>
		<script>
            // data
            var hairImg = "<?php echo $data->hair_img; ?>";
            var mainGroup = <?php echo $data->hair_maingroup; ?>;
            var colors = <?php echo $data->hair_colors; ?>;
            
            // app 
            var hairApp = "hairStyle_<?php echo $data->ID; ?>";
            var hairController = "hairStyleController_<?php echo $data->ID; ?>";
            var hairAppSize = {
                width: 1600,
                height: 1200
            };
            var headerHeight = <?php echo $data->hair_top? $data->hair_top: 0; ?>;
        </script>

        <div class="hair" ng-app="hairStyle_<?php echo $data->ID; ?>" ng-controller="hairStyleController_<?php echo $data->ID; ?>">
            <div hair-wrap="1">
                <div class="hair-front">
                    <div class="hair-mask"></div>
                    <div class="hair-group">
                        <div ng-repeat="h in colors">
                            <img ng-repeat="i in h.items" ng-src="{{i.hair}}" ng-class="selHair.id == i.id? 'active': ''"/>
                        </div>
                        <img ng-src="{{hairImg}}" class="hair-main"/>
                    </div>
                </div>
                <div class="hair-detail">
                    <div class="hair-info">
                        <!-- <h2><span>S</span>ANOTINT <sup>®</sup> <span>C</span>LASSIC</h2> -->
						<h2><span>SANOTINT</span> <sup>®</sup></h2>
                        <!--<p>
                            CON SANOTINT® CLASSIC È POSSIBILE OTTENERE IL TONO DI COLORE DESIDERATO IN MODO SEMPLICE, RAPIDO ED EFFICACE.<br/>
                            LE PREZIOSE MATERIE PRIME NATURALI DI SANOTINT® PROTEGGONO IL CAPELLO E INVITANO A SEGUIRE LA DOLCE MELODIA DELLE STAGIONI
                        </p>-->
                    </div>
                    <div class="hair-groups">
                        <ul hair-mainGroup="main-group">
                            <li ng-repeat="g in groups">
                                <button ng-click="colorGroupSel(g);" class="color-group-button-{{$index}}">{{g.name}}</button>
                                <ul ng-if="g.colors.length > 1" class="color-group color-group-{{$index}}">
                                    <li ng-repeat="c in g.colors"><button ng-click="colorSel(c)">{{c.group}}</button></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="hair-colors">
                        <div class="hair-colors-wrap">
                            <div class="hair-color-group" ng-repeat="h in colors" ng-if="h.main == selColor.main && h.group == selColor.group">
                                <div hair-group="h.group">
                                    <li ng-repeat="i in h.items" ng-class="selHair.id == i.id? 'active': ''" data-shop="{{i.shop}}" hair-color="i.id">
                                        <div class="hair-color"><img ng-click="hairSel(i)" ng-src="{{i.thumb}}"/></div>
                                        <span>{{i.name}}</span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hair-order after-clear">
                        <div class="hair-sel"><label id="hair-color-num">{{selHair.num}}</label> - {{selHair.name}}</div>
                        <div class="hair-action">
                            <!-- <a ng-href="{{selHair.shop}}" ng-if="selHair.shop" target="_blank" class="hair-order-btn"><span>A</span>cquista <span>O</span>ra!</a> -->
							<a ng-href="{{selHair.shop}}" ng-if="selHair.shop" target="_blank" class="hair-order-btn">Acquista Ora!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php
}
?>
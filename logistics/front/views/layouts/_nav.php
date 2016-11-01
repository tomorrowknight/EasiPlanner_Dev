<?
use yii\helpers\Url;
use chief725\libs\Utils;
use yii\bootstrap\Nav;

if (Yii::$app->user->can ( "admin" )) {
	$items = array (
			[
					'label' => Utils::icon ( "cogs" ) . ' Admin',
					'url' => [
							'/user/admin'
					]
			]
	);
}elseif (Yii::$app->user->can ( "driver" )) {
	$items = array (

	);
} elseif (! Yii::$app->user->isGuest) {
	$items = array (
			[
					'label' => Utils::iconfa ( "users" ) . 'Driver',
					'url' => [
							'/driver'
					]
			],
			[
					'label' => Utils::iconfa ( "truck" ) . 'Vehicle',
					'url' => [
							'/vehicle'
					]
			],

			[
					'label' => Utils::iconfa ( "gift" ) . 'Parcel',
					'url' => [
							'/parcel'
					]
			],
			[
					'label' => Utils::iconfa ( "map-marker" ) . 'Map',
					'url' => [
							'/map'
					]
			],
			[
					'label' => Utils::iconfa ( "cog" ) . 'Profile',
					'url' => [
							'/user/profile'
					]
			],
			[
					'label' => Utils::iconfa ( "bars" ) . 'Horizon',
					'url' => [
							'/horizon'
					]
			],
			//	[					'label' => Utils::iconfa ( "car" ) . 'Special Requirements',					'url' => [							'/vehicle-type'					]			]
	);
}
$items [] = [
		'label' => Utils::iconfa ( "map" ) . 'Geocode',
		'url' => [
				'/geocode'
		],
		'visible' => Utils::isAdmin ()
];
$items [] = Yii::$app->user->isGuest ? [
		'label' => Utils::iconfa ( "question" ) . ' Help',
		'url' => 'http://help.logistics.lol'
	
] : [
		'label' => Utils::iconfa ( "sign-out" ) . 'Logout',
		'url' => [
				'/user/logout'
		],
		'linkOptions' => [
				'data-method' => 'post'
		]
];

echo Nav::widget ( [
		'options' => [
				'class' => 'nav navbar-nav pull-right'
		],
		'items' => $items,
		'encodeLabels' => false,
		'activateParents' => true
] );
?>
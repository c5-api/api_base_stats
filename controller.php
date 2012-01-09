<?php defined('C5_EXECUTE') or die("Access Denied.");

class ApiBaseStatsPackage extends Package {

	protected $pkgHandle = 'api_base_stats';
	protected $appVersionRequired = '5.5.0';
	protected $pkgVersion = '1.0';

	public function getPackageName() {
		return t("Api:Base:Stats");
	}

	public function getPackageDescription() {
		return t("A concrete5 API route for getting and exporting site statistics.");
	}

	public function install() {
		$installed = Package::getByHandle('api');
		if(!is_object($installed)) {
			throw new Exception(t('Please install the "API" package before installing %s', $this->getPackageName()));
		}
		$api = array();
		$api['pkgHandle'] = $this->pkgHandle;
		$api['route'] = 'stats';
		$api['routeName'] = t('Get Stats');
		$api['class'] = 'stats';
		$api['method'] = 'getStats';
		$api['via'][] = 'get';

		$api2 = array();
		$api2['pkgHandle'] = $this->pkgHandle;
		$api2['route'] = 'stats/export';
		$api2['routeName'] = t('Export Stats');
		$api2['class'] = 'user';
		$api2['method'] = 'exportStats';
		$api2['via'][] = 'get';

		Loader::model('api_register', 'api');
		ApiRegister::add($api);
		ApiRegister::add($api2);

		parent::install(); //install the addon - meh
	}

	public function uninstall() {
		Loader::model('api_register', 'api');
		ApiRegister::removeByPackage($this->pkgHandle);//remove all the apis
		parent::uninstall();
	}

}
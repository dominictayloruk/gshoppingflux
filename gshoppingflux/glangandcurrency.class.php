<?php
// <!--
// Licensed to the Apache Software Foundation (ASF) under one
// or more contributor license agreements.  See the NOTICE file
// distributed with this work for additional information
// regarding copyright ownership.  The ASF licenses this file
// to you under the Apache License, Version 2.0 (the
// "License"); you may not use this file except in compliance
// with the License.  You may obtain a copy of the License at

//   http://www.apache.org/licenses/LICENSE-2.0

// Unless required by applicable law or agreed to in writing,
// software distributed under the License is distributed on an
// "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
// KIND, either express or implied.  See the License for the
// specific language governing permissions and limitations
// under the License.
// //-->

class GLangAndCurrency
{
	public static function getLangCurrencies($id_lang, $id_shop)
	{
		$ret = Db::getInstance()->executeS('SELECT glc.* '
			 . 'FROM '._DB_PREFIX_.'gshoppingflux_lc glc '
			 . 'WHERE glc.id_glang IN (0, '.(int)$id_lang.') '
			 . 'AND glc.id_shop IN (0, '.(int)$id_shop.');');
		$ret[0] = array_merge($ret[0],Language::getLanguage($id_lang));
		return $ret;
	}
	
	public static function getAllLangCurrencies($active = false)
	{
		$sql = 'SELECT glc.* FROM '._DB_PREFIX_.'gshoppingflux_lc glc '
			 . 'INNER JOIN '._DB_PREFIX_.'lang lg ON (glc.id_glang = lg.id_lang) ';
		if($active) $sql .= 'WHERE lg.active = 1 ';
		$sql .= ';';
		$ret = Db::getInstance()->executeS($sql);
		foreach($ret as $k => $v){$ret[$k] = array_merge($ret[$k],Language::getLanguage($ret[$k]['id_glang']));}
		return $ret;
	}

	public static function add($id_lang, $id_currency, $id_shop)
	{
		if(empty($id_lang) || empty($id_shop))
			return false;

		Db::getInstance()->insert('gshoppingflux_lc', array(
			'id_glang'=>(int)$id_lang,
			'id_currency' => $id_currency,
			'id_shop' => (int)$id_shop
			)
		);
	}

	public static function update($id_lang, $id_currency, $id_shop)
	{
		if(empty($id_lang) || empty($id_shop))
			return false;

		Db::getInstance()->update('gshoppingflux_lc', array(
				'id_currency' => $id_currency
			),
			'id_glang = '.(int)$id_lang.' AND id_shop='.(int)$id_shop
		);
	}

	public static function remove($id_lang, $id_shop)
	{
		Db::getInstance()->delete('gshoppingflux_lc', 'id_glang = '.(int)$id_lang.' AND id_shop = '.(int)$id_shop);
	}

}
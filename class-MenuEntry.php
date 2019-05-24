<?php
# Copyright (C) 2015, 2018, 2019 Valerio Bozzolan
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

/**
 * Define a menu entry
 *
 * Some menu entries define a menu tree and can be displayed later.
 */
class MenuEntry {

	/**
	 * Menu user identifier
	 *
	 * e.g. 'home'
	 *
	 * @var string
	 */
	public $uid;

	/**
	 * Identifier of the parent menu
	 *
	 * @var array|string|null
	 */
	public $parentUid;

	/**
	 * URI of the menu
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Menu title
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Permission to show this menu
	 *
	 * @var string
	 */
	public $permission;

	/**
	 * Extra metadata
	 */
	public $extra;

	/**
	 * Constructor
	 *
	 * @param string $uid        Menu user identifier e.g. 'home'
	 * @param string $url        Page URL e.g. 'home.html'
	 * @param string $name       Page name
	 * @param string $parent_uid Parent menu user identifier
	 * @param string $permission Permission required to see this page
	 * @param string $extram     Extra metadata
	 */
	function __construct( $uid, $url = null, $name = null, $parent_uid = null, $permission = null, $extra = null ) {
		$this->uid        = $uid;
		$this->url        = $url;
		$this->name       = $name;
		$this->parentUid  = $parent_uid;

		// backward compatibility
		if( is_array( $permission ) ) {
			error( "deprecated use of MenuEntry: now the #5 argument is \$permission and not $extra" );
			$extra = $permission;
			$permission = null;
		}

		$this->permission = $permission;
		$this->extra = $extra;
	}

	/**
	 * Call site_page() on the URL
	 *
	 * @param $full_url boolean
	 * @return string
	 * @see site_page()
	 */
	public function getSitePage( $full_url = false ) {
		return site_page( $this->url, $full_url );
	}

	/**
	 * Check if the user has the permission to see this page
	 *
	 * @return boolean
	 */
	public function isVisible() {
		return $this->permission ? has_permission( $this->permission ) : true;
	}

	/**
	 * Get a metadata by name (alias)
	 */
	public function getExtra( $arg, $default = null ) {
		return $this->get($arg, $default);
	}

	public function get( $arg, $default = null ) {
		if( isset( $this->extra[ $arg ] ) ) {
			return $this->extra[ $arg ];
		}
		return $default;
	}
}

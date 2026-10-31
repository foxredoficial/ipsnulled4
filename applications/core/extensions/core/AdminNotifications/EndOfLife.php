<?php
/**
 * @brief		ACP Notification Extension
 * @author		<a href='https://www.invisioncommunity.com'>Invision Power Services, Inc.</a>
 * @copyright	(c) Invision Power Services, Inc.
 * @license		https://www.invisioncommunity.com/legal/standards/

 * @since		29 Mar 2026
 */

namespace IPS\core\extensions\core\AdminNotifications;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !\defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

/**
 * ACP  Notification Extension
 */
class _EndOfLife extends \IPS\core\AdminNotification
{	
	/**
	 * @brief	Identifier for what to group this notification type with on the settings form
	 */
	public static $group = 'important';
	
	/**
	 * @brief	Priority 1-5 (1 being highest) for this group compared to others
	 */
	public static $groupPriority = 1;
	
	/**
	 * @brief	Priority 1-5 (1 being highest) for this notification type compared to others in the same group
	 */
	public static $itemPriority = 1;
	
	/**
	 * Title for settings
	 *
	 * @return	string
	 */
	public static function settingsTitle()
	{
		return 'acp_notification_ips4_eol';
	}
	
	/**
	 * Can a member access this type of notification?
	 *
	 * @param	\IPS\Member	$member	The member
	 * @return	bool
	 */
	public static function permissionCheck( \IPS\Member $member ): bool
	{
		return !\IPS\IPS::isManaged();
	}
	
	/**
	 * Is this type of notification ever optional (controls if it will be selectable as "viewable" in settings)
	 *
	 * @return	string
	 */
	public static function mayBeOptional()
	{
		return FALSE;
	}
	
	/**
	 * Is this type of notification might recur (controls what options will be available for the email setting)
	 *
	 * @return	bool
	 */
	public static function mayRecur(): bool
	{
		return FALSE;
	}
			
	/**
	 * Notification Title (full HTML, must be escaped where necessary)
	 *
	 * @return	string
	 */
	public function title(): string
	{
		return \IPS\Member::loggedIn()->language()->addToStack('acp_notification_ips4_eol');
	}
	
	
	/**
	 * Notification Body (full HTML, must be escaped where necessary)
	 *
	 * @return	string
	 */
	public function body()
	{
		if( \IPS\CIC )
		{
			$linkTarget = \IPS\Http\Url::external( 'https://invisioncommunity.com/clientarea/switch-to-five/' . \IPS\Cicloud\getCicUsername() . '/' );
		}
		else
		{
			$linkTarget = \IPS\Http\Url::ips( 'docs/v5_classic_upgrade_guide' );
		}
		return \IPS\Theme::i()->getTemplate( 'notifications', 'core', 'admin' )->ips4Eol( $linkTarget );
	}
	
	/**
	 * Severity
	 *
	 * @return	string
	 */
	public function severity(): string
	{
		return static::SEVERITY_CRITICAL;
	}
	
	/**
	 * Dismissible?
	 *
	 * @return	string
	 */
	public function dismissible(): string
	{
		return static::DISMISSIBLE_MONTHLY;
	}
	
	/**
	 * Style
	 *
	 * @return	bool
	 */
	public function style(): string
	{
		return static::STYLE_WARNING;
	}
	
	/**
	 * Quick link from popup menu
	 *
	 * @return	\IPS\Http\Url
	 */
	public function link(): \IPS\Http\Url
	{
		if( \IPS\CIC )
		{
			$license = \IPS\IPS::licenseKey();
			return \IPS\Http\Url::external( 'https://invisioncommunity.com/clientarea/switch-to-five/' . $license['account'] . '/' );
		}
		else
		{
			return \IPS\Http\Url::ips( 'docs/v5_classic_upgrade_guide' );
		}
	}
}
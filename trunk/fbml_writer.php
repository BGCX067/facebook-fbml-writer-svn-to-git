<?php
//
// +---------------------------------------------------------------------------+
// | Facebook FBML Writer                                                      |
// +---------------------------------------------------------------------------+
// | AltoDot Inc.                                                              |
// |                                                                           |
// +---------------------------------------------------------------------------+
// | For help with this library, contact ffw@altodot.com                       |
// +---------------------------------------------------------------------------+

define('ALLOW_SPECIAL_ATTRIBUTES', false);

class FBMLWriter {

/**
 * Renders the name of the user specified, optionally linked to his or her
 * profile.
 * This also works for Facebook Pages with the ID of the Page passed as the
 * uid parameter.
 * You can use this tag for both the subject and the object of a sentence
 * describing an action. For example, if a user with the user ID $tagger tags
 * a photo of a user with the user ID $tagee, you could say:
 *
 * <fb:name uid="$tagger" capitalize="true" /> tagged a photo of
 * <fb:name subjectid="$tagger" uid="$tagee" />
 *
 * User names and profile links follow standard Facebook privacy rules for other viewing users.
 *
 * @link http://wiki.developers.facebook.com/index.php/Fb:name
 *
 * @param int $uid The ID of the user or Page whose name you want to show.
 *                 Alternately, you can use "profileowner" only on a user's
 *                 profile; you can use "loggedinuser" only on canvas pages.
 * @param bool $firstnameonly Show only the user's first name.
 * @param bool $linked Link to the user's profile.
 * @param bool $lastnameonly Show only the user's last name.
 * @param bool $possessive Make the user's name possessive (e.g. Joe's instead
 *                         of Joe).
 * @param bool $reflexive Use "yourself" if useyou is true.
 * @param bool $shownetwork Displays the primary network for the uid.
 * @param bool $useyou Use "you" if uid matches the logged in user.
 * @param string $ifcantsee Alternate text to display if the logged in user
 *                          cannot access the user specified. To specify an
 *                          empty string instead of the default, use
 *                          ifcantsee="".
 * @param bool $capitalize Capitalize the text if useyou==true and
 *                         loggedinuser==uid.
 * @param int $subjectid The Facebook ID of the subject of the sentence where
 *                        this name is the object of the verb of the sentence.
 *                        Will use the reflexive when appropriate.
 *                        When subjectid is used, uid is considered to be the
 *                        object and uid's name is produced.
 * @return string
 */
  static function name($uid, $firstnameonly = null, $linked = null,
      $lastnameonly = null, $possessive = null,
      $reflexive = null, $shownetwork = null, $useyou = null,
      $ifcantsee = null, $capitalize = null, $subjectid = null) {

    $result = '<fb:name uid="' . $uid . '" ';

    if ($firstnameonly) {
      $result .= 'firstnameonly="' . ($firstnameonly)?'true':'false' . '" ';
    }
    if ($linked) {
      $result .= 'linked="' . ($linked)?'true':'false' . '" ';
    }
    if ($lastnameonly) {
      $result .= 'lastnameonly="' . ($lastnameonly)?'true':'false' . '" ';
    }
    if ($possessive) {
      $result .= 'possessive="' . ($possessive)?'true':'false' . '" ';
    }
    if ($reflexive) {
      $result .= 'reflexive="' . ($reflexive)?'true':'false' . '" ';
    }
    if ($shownetwork) {
      $result .= 'shownetwork="' . ($shownetwork)?'true':'false' . '" ';
    }
    if ($useyou) {
      $result .= 'useyou="' . ($useyou)?'true':'false' . '" ';
    }
    if ($ifcantsee) {
      $result .= 'ifcantsee="' . $ifcantsee . '" ';
    }
    if ($capitalize) {
      $result .= 'capitalize="' . ($capitalize)?'true':'false' . '" ';
    }
    if ($subjectid) {
      $result .= 'subjectid="' . $subjectid . '" ';
    }

    if(ALLOW_SPECIAL_ATTRIBUTES) {
      $result .= 'sa="" ';
    }

    $result = '/>';

    return $result;
  }

  /**
   * Hides the content enclosed in this tag from any user who is blocked by the
   * user whose uid is referenced in fb:user.
   *
   * For example, Alice and Bob are friends. Carol and Bob are friends. Alice
   * and Carol are not friends. Alice cannot see Carol's profile, but Carol has
   * not blocked her and vice versa. Carol writes on Bob's Wall. Alice can see
   * Carol's Wall post and her name, though she still can't see Carol's profile.
   *
   * However, if Carol blocks Alice (or vice versa), then Carol's Wall post
   * won't show up at all.
   * If you want to hide user content based on a privacy check,
   * use Fb:if-can-see.
   *
   * @link http://wiki.developers.facebook.com/index.php/Fb:user
   *
   * @param int $uid
   * @param string $content
   * @return string
   */
  static function user($uid, $content = null) {
    $result = '<fb:user uid="' . $uid . '" >';

    if ($content) {
      $result .= $content;
    }

    $result = '</fb:user>';

    return $result;
  }

  /**
   * Renders a pronoun for a specific user. If you include no additional
   * parameters, then you is displayed if the user with uid is viewing the page.
   * If another user is the viewer, then he or she is displayed if the gender is
   * known; otherwise, they is displayed.
   *
   * @link http://wiki.developers.facebook.com/index.php/Fb:pronoun
   *
   * @param int $uid The user ID for whom to generate the pronoun. You can
   *                 specify user IDs for multiple users by separating them with
   *                 a comma, as in: uid="1234, 5678". You can substitute actor
   *                 for the user ID so you can more easily aggregate
   *                 Feed stories.
   * @param bool $useyou Use the word "you" if uid is viewing the page.
   * @param bool $possessive Use the possessive form (his/her/your/their).
   * @param bool $reflexive Use the reflexive form
   *                        (himself/herself/yourself/themself).
   * @param bool $objective Use the objective form (him/her/you/them).
   * @param bool $usethey Use "they" if gender is not specified.
   * @param bool $capitalize Force a capital letter for the pronoun.
   * @return string
   */
  static function pronoun($uid, $useyou = null, $possessive = null,
      $reflexive = null, $objective = null, $usethey = null,
      $capitalize = null) {

    $result = '<fb:pronoun uid="' . $uid . '" ';

    if ($useyou) {
      $result .= 'useyou="' . ($useyou)?'true':'false' . '" ';
    }
    if ($possessive) {
      $result .= 'possessive="' . ($possessive)?'true':'false' . '" ';
    }
    if ($reflexive) {
      $result .= 'reflexive="' . ($reflexive)?'true':'false' . '" ';
    }
    if ($objective) {
      $result .= 'objective="' . ($objective)?'true':'false' . '" ';
    }
    if ($usethey) {
      $result .= 'usethey="' . ($usethey)?'true':'false' . '" ';
    }
    if ($capitalize) {
      $result .= 'capitalize="' . ($capitalize)?'true':'false' . '" ';
    }

    if(ALLOW_SPECIAL_ATTRIBUTES) {
      $result .= 'sa="" ';
    }

    $result = '/>';

    return $result;
  }

  /**
   * Turns into an img tag for the specified user's or Facebook Page's profile
   * picture. The tag itself is treated like a standard img tag, so attributes
   * valid for img are valid with fb:profile-pic as well. So you could specify
   * width and height settings instead of using the size attribute, for example.
   *
   * @link http://wiki.developers.facebook.com/index.php/Fb:profile-pic
   *
   * FBMLWriter::profile_pic(123456, ProfilePictureSize::SQUARE, false, true);
   *
   * @param int $uid  The user ID of the profile or Facebook Page for the
   *                  picture you want to display
   * @param ProfilePictureSize $size  ProfilePictureSize object type
   * @param bool $linked  Make the image a link to the user's profile. (Default
   *                      value is true.)
   * @param bool $facebook_logo  When set to true, it returns the Facebook
   *                             favicon image, which gets overlaid on top of
   *                             the user's profile on a site.
   * @param int $width
   * @param int $height
   * @return string
   */
  static function profile_pic($uid, $size = null, $linked = null, $facebook_logo = null, $width = null, $height = null) {
    $result = '<fb:profile-pic uid="' . $uid . '" ';

    if ($size) {
      $result .= 'size="' . $size . '" ';
    }
    if ($linked) {
      $result .= 'linked="' . ($linked)?'true':'false' . '" ';
    }
    if ($facebook_logo) {
      $result .= 'facebook_logo="' . ($facebook_logo)?'true':'false' . '" ';
    }
    if ($width) {
      $result .= 'width="' . $width . '" ';
    }
    if ($height) {
      $result .= 'height="' . $height . '" ';
    }

    if(ALLOW_SPECIAL_ATTRIBUTES) {
      $result .= 'sa="" ';
    }

    $result = '/>';

    return $result;
  }

  /**
   * Prints the specified event name and formats it as a link to the event's page.
   *
   * @link http://wiki.developers.facebook.com/index.php/Fb:eventlink
   *
   * @param int $eid Event ID for the event whose name and link you want to
   *                 retrieve.
   * @return string
   */
  static function eventlink($eid) {
    $result = '<fb:eventlink eid="' . $eid . '" ';

    if(ALLOW_SPECIAL_ATTRIBUTES) {
      $result .= 'sa="" ';
    }

    $result = '/>';

    return $result;
  }

  /**
   * Prints the specified group name and formats it as a link to the group's
   * page.
   *
   * @link http://wiki.developers.facebook.com/index.php/Fb:grouplink
   *
   * @param int $gid Group ID for the group whose name and link you want to
   *                 retrieve.
   * @return string
   */
  static function grouplink($gid) {
    $result = '<fb:eventlink gid="' . $gid . '" ';

    if(ALLOW_SPECIAL_ATTRIBUTES) {
      $result .= 'sa="" ';
    }

    $result = '/>';

    return $result;
  }

  /**
   * Displays content inside the tag only if the user is in a given network.
   * Note: You can use fb:else with fb:is-in-network, even though the tag does
   * not start with fb:if-.
   *
   * @link http://wiki.developers.facebook.com/index.php/Fb:is-in-network
   *
   * @param int $network The network ID to check. You can check one network at a time.
   * @param int $uid The user ID to check.
   * @param string $content
   * @return string
   */
  static function is_in_network($network, $uid = null, $content = null) {
    $result = '<fb:is-in-network network="' . $network . '" ';

    if ($uid) {
      $result .= 'uid="' . $uid . '" ';
    }

    $result .= '>';

    if ($content) {
      $result .= $content;
    }

    if(ALLOW_SPECIAL_ATTRIBUTES) {
      $result .= 'sa="" ';
    }

    $result = '</fb:is-in-network>';

    return $result;
  } 

  /**
   * This Method is used to extend the basic FBML tags adding custom atributes
   * such as style, id, class, onclick and so on.
   *
   * The call to this method should look like this:
   *
   * $myTagString = FBMLWriter::set_special_attributes($myFBMLTagResult,
   *                                             "style='color:#000' id='1'");
   *
   *
   * @param string $target
   * @param string $atributesString
   * @return string
   */
  static function set_special_attributes($target, $attributesString) {
    if (ALLOW_SPECIAL_ATTRIBUTES) {
      return str_replace('sa=""', $attributesString);
    }
    else {
      return $target;
    }

  }

}

class ProfilePictureSize {
/**
 * THUMB represents an image of 50 px wide
 */
  const THUMB = "thumb";
  /**
   * NORMAL represents an image of 50 px wide
   */
  const NORMAL = "normal";
  /**
   * SMALL represents an image of 50 px wide
   */
  const SMALL = "small";
  /**
   * SQUARE represents an image of 50 px wide
   */
  const SQUARE = "square";
}


$profilePicture = FBMLWriter::profile_pic(123456,ProfilePictureSize::SQUARE);
$profilePicture = FBMLWriter::set_special_attributes($profilePicture, "hspace='10'");

?>

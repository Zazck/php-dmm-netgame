<?php

/* 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

use function GuzzleHttp\json_decode;

require 'vendor/autoload.php';

date_default_timezone_set("Asia/Tokyo");

class Config {
  // 启用或者关闭"模拟地区Cookies" 启用: true  禁用: false
  // 中国大陆服务器无效, 其余区域尚不明确
  // use fake cookies if server doesn't have a Japan IP. available value: true / false
  public const fakeCookies = false;
  // 防止其他'网站'伪造请求, 不能防止本地应用伪造请求, 用自己的站点网址替换, 中括号, 引号以及逗号必须为英文半角符号
  // whitelist for cross site requests
  public const allowed = ['http://localhost:3000', 'http://localhost:4200', 'http://react.dmm.zazck.work', 'http://dmm.zazck.work']; 
  // cacert.pem证书文件位置, 设置为 '' 后会使用php设置的默认证书. 能使用默认证书尽量使用默认证书, 范例: linux: '~/cacert.pem', windows: 'C:\Users\username\cacert.pem'
  // the path to your cacert. example: linux: '~/cacert.pem', windows: 'C:\Users\username\cacert.pem'
  public const customPemFile = '';
}

class Result {
  public const OK = 0;
  public const INVALID_INPUT = -1;
  public const NETWORK_ERROR = -2;
  public const DMM_TOKEN_NOT_FOUND = -10;
  public const TOKEN_NOT_FOUND = -11;
  public const DMM_METHOD_CHANGED = -12;
  public const DMM_PASSWORD_RESET = -13;
  public const DMM_INVALID_INPUT = -14;
  public const DMM_GAME_INSTALL_NEEDED = -15;
  public const DMM_GAME_ALREADY_INSTALLED = -16;
  public const DMM_TOKEN_EXPIRED = -17;
  public const DMM_INVALID_EMAIL_PASSWORD = -18;
  public const DMM_FORCE_REDIRECT = -19;
  public const DMM_REQUIRE_PROFILE = -20;
}

class InstallOptions {
  public static $notification = 0;
  public static $myapp = 0;
}

class Constants {
  public const urls = [
    "general" => 'dmm.com',
    "adult" => 'dmm.co.jp',
    "www" => [
      "login" => 'https://www.%s/my/-/login/',
      "ajax" => 'https://www.%s/my/-/login/ajax-get-token/',
      "auth" => 'https://www.%s/my/-/login/auth/',
    ],
    "accounts" => [
      "login" => 'https://accounts.%s/service/login/password',
      "ajax" => 'https://accounts.%s/service/api/get-token',
      "auth" => 'https://accounts.%s/service/login/password/authenticate',
    ],
    "app" => 'https://games.%s/detail/%s/',
    "play" => 'http://pc-play.games.%s/play/%s/',
    "logout" => 'https://www.%s/my/-/login/logout/=/path=DRVESVwZTlVZCFRLHVILWk8GWRhaSQ__/',
    "pc" => 'https://www.%s/misc/-/cookie/layout/=/path=DRVESVwZTlVZCFRLHVILWk8GWRhaSQ__/value=pc/',
    "age_check" => 'https://www.%s/age_check/=/declared=yes/rurl=DRVESVwZTkVPEh9cXltIVA5LXEYfTQtJTQ__/',
    "exchange" => 'https://www.%s/service/-/exchange/=/?url=https%%3A%%2F%%2Fwww.%s%%2Ftop%%2F',
    "update_st" => 'http://pc-play.games.%s/play/%s/check/ajax-index/',
    "profile" => 'https://personal.games.%s/profile/regist',
    // "profile" => 'http://personal.games.%s/profile/regist?redirect_url=DRVESVwZTlVZCFRLHVILWk8GWVsfXQFNAwtbSUYKX1sADx9QCEUVU1QJDllDRjleBVgOBAUJVQtEDFgSWwNeUwQVWVYIC1EUVRxQSEMLVg__',
    "confirm" => 'https://personal.games.%s/profile/regist/confirm',
    "registration" => 'https://personal.games.%s/profile/regist/registration',
    "commit" => 'https://personal.games.%s/profile/regist/commit',
    // "reminder" => 'https://accounts.dmm.com/service/password-reminder',
    // "reminder_cn" => 'https://www.dmm.com/my/-/passwordreminder',
    "payment" => [
      "new" => [
        "index" => 'http://pc-play.games.%s/play/%s/point/ajax-index?payment_id=%s',
        "cancel" => 'http://pc-play.games.%s/play/%s/point/ajax-cancel?payment_id=%s/',
        "commit" => 'http://pc-play.games.%s/play/%s/point/ajax-commit?payment_id=%s/',
      ],
      "old" => [
        "index" => 'http://www.%s/netgame/social/application/-/purchase/=/app_id=%d/payment_id=%s/',
        "cancel" => 'http://www.%s/netgame/social/application/-/purchase/=/act=cancel/app_id=%d/payment_id=%s/',
        "commit" => 'http://www.%s/netgame/social/application/-/purchase/=/act=purchase/app_id=%d/payment_id=%s/'
      ],
    ],
  ];

  public const keywords = [
    "www" => [
      "dmm_token" => '"DMM_TOKEN",',
      "token" => '"token":',
      "header_dmm_token" => "DMM_TOKEN",
      "header_xhr" => "X-Requested-With",
    ],
    "accounts" => [
      "dmm_token" => '="csrf-http-dmm-token" content=',
      "token" => 'name="token" value=',
      "header_dmm_token" => "http-dmm-token",
      "header_xhr" => "x-requested-with",
    ],
    "gadget_info" => [
      "gadget_info" => 'gadgetInfo = ',
      "viewer_id" => 'VIEWER_ID',
      "owner_id" => 'OWNER_ID',
      "app_id" => 'APP_ID',
      "url" => 'URL',
      "st" => 'ST',
      "time" => 'TIME',
      "type" => 'type',
      "update_st" => 'updateSecurityToken : function',
      "token" => '_token'
    ],
    "regist" => [
      "token" => '_token" type="hidden" value=',
    ],
    "payment" => [
      "gameTitle" => ['<p class="mg-b12 left tx14">', '</p>'],
      "itemTitle" => ['<span class="bold tx16">', '</span>'],
      "itemImage" => '<img src=',
      "itemInfo" => ['<dl class="item-info left">', '</dl>'],
      "itemDetail" => ['<dd>', '</dd>'],
      "itemDescription" => ['<p>', '</p>'], 
      "itemPrice" => ['単価:<span class="tx24">', '</span>'],
      "itemCount" => ['個数:<span class="tx24">', '</span>'],
      "pointContainer" => ['<dl class>', '</dl>'],
      "point" => ['<dd>', '</dd>'],
    ],
    "osapi" => 'URL',
    "reset" => '認証エラー',
    'error' => 'error',
    "install" => 'installUrl',
    "runGame" => 'runGame',
    "host" => 'host',
    "titleId" => 'titleId',
    "dmm_account_login" => 'DMMアカウントにログイン',
    "dmm_invalid_email_password" => 'メールアドレスまたはパスワードが正しくありません。',
    "iframe_width" => '"area-game" style=',
    "age_check" => 'age_check',
    "force_redirect" => 'ページが切り替わらない方は',
    "login" => 'login',
    "login_jp" => 'ログインしてください。',
    "login_jp_tag" => '>ログイン</a>',
    "confirm" => '入力内容を確認する',
    "profile" => 'profile',
    "redirect_link" => '<a href=',
  ];
}

class User {
  public static $login_id = '';
  public static $password = '';
  public static $token = '';
  public static $dmm_token = '';
  public static $idKey = '';
  public static $pwKey = '';
}

class GadgetInfo {
  public static $viewer_id = 0;
  public static $owner_id = 0;
  public static $app_id = 0;
  public static $url = '';
  public static $st = '';
  public static $time = 0;
  public static $type = '';
  public static $token = '';

  public static function jsonSerialize() {
    return get_class_vars(__CLASS__);
  }
}

class RegistPayload {
  public static $nickname = '';
  public static $gender = 'male';
  public static $year = '1900';
  public static $month = '01';
  public static $day = '01';
  public static $isGeneralChecked = false;
  public static $isAdultChecked = false;
}

class Session {
  public static $login_sub_site = '';
  public static $app_name = '';
  public static $app_id = 0;
  public static $app_base = Constants::urls['general'];
  public static $cookies = [];
  public static $iframe_width = 0;
}

class Payment {
  public static $payment_id = '';
  public static $version = 'new';
}

class API {
  /**
   * @access private
   * @var \GuzzleHttp\Client
   */
  private $client;
  /** @var \GuzzleHttp\Cookie\CookieJar $cookie_jar Our cookie_jar */
  private $cookie_jar;

  private function match_symbol_pair(
    string $before,
    string $after,
    string $data,
    int $offset = 0
  ): string {
    $startSymbol = strpos($data, $before, $offset);
    if ($startSymbol === false) {
      return '';
    }
    $startPos = $startSymbol + strlen($before);

    $endSymbol = strpos($data, $after, $startPos);
    if ($endSymbol === false) {
      return '';
    }
    return substr($data, $startPos, $endSymbol - $startPos);
  }

  private function match_symbol_pair_after(
    string $before,
    string $after,
    string $data,
    string $search,
    int $offset = 0
  ): string {
    $start = strpos($data, $search, $offset);
    if ($start === false) {
      return '';
    }

    return $this->match_symbol_pair($before, $after, $data, $start + strlen($search));
  }

  private function match_double_quotes_after(string $data, string $search, int $offset = 0): string {
    return $this->match_symbol_pair_after('"', '"', $data, $search, $offset);
  }

  private function match_brackets_after(string $data, string $search, int $offset = 0): string {
    return $this->match_symbol_pair_after('(', ')', $data, $search, $offset);
  }

  private function match_curly_brackets_after(string $data, string $search, int $offset = 0): string {
    return $this->match_symbol_pair_after('{', '}', $data, $search, $offset);
  }

  private function match_gadget_value_after(string $data, string $search, int $offset = 0): string {
    return $this->match_symbol_pair_after(': ', ',', $data, $search, $offset);
  }

  private function response($result, $data = ''): void {
    if (Config::fakeCookies === true) {
      /** @var [][] $cookies 获取的Cookies列表, 独立于cookie_jar, 可能被转换成了全数组的形式 */
      $cookies = $this->cookie_jar->toArray();
      $this->cookie_jar->clear();
      foreach ($cookies as $cookie) {
        $cookie = new \GuzzleHTTP\Cookie\SetCookie($cookie);
        if ($cookie->getName() !== null && strcasecmp($cookie->getName(), 'ckcy') === 0) {
          $cookie->setValue("1");
        }
        $this->cookie_jar->setCookie($cookie);;
      }
    }
    echo(json_encode([
      'code' => $result,
      'data' => $data,
      'cookies' => isset($this->cookie_jar) ? $this->cookie_jar->toArray() : null,
    ]));
  }

  private function get_dmm_tokens(): int {
    $this->cookie_jar->clearSessionCookies(); // make sure cookie is clean after expired
    $url = '';
    $response = $this->client->get(sprintf(Constants::urls['www']['login'], Session::$app_base), [
      'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$url) {
        $url = $stats->getEffectiveUri();
      },
    ]);
    $urlStart = strpos($url, '//') + 2;
    $responseHost = substr($url, $urlStart, strpos($url, '/', $urlStart) - $urlStart);
    Session::$login_sub_site = substr($responseHost, 0, strpos($responseHost, '.'));

    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    $responseBody = (string)$response->getBody();

    if (strpos($responseBody, Constants::keywords['force_redirect']) !== false) {
      return Result::DMM_FORCE_REDIRECT;
    }

    $match = $this->match_double_quotes_after($responseBody, Constants::keywords[Session::$login_sub_site]['token']);

    if (strlen($match) > 0) {
      User::$token = $match;
    } else {
      return Result::TOKEN_NOT_FOUND;
    }

    return Result::OK;
  }

  private function authenticate() {
    $headers = [
      'Host' => Session::$login_sub_site.'.'.Session::$app_base,
      'Origin' => 'https://'.Session::$login_sub_site.'.'.Session::$app_base,
      'Referer' => Constants::urls[Session::$login_sub_site]['login'],
    ];
    $data = [
      'token' => User::$token,
      'login_id' => User::$login_id,
      'save_login_id' => intval($_POST['save_login_id']),
      'password' => User::$password,
      'save_password' => intval($_POST['save_password']),
      'use_auto_login' => intval($_POST['use_auto_login']),
      'path' => '',
      'prompt' => '',
      'client_id' => '',
      'display' => '',
      'recaptchaToken' => '',
    ];

    $response = $this->client
      ->post(sprintf(Constants::urls[Session::$login_sub_site]['auth'], Session::$app_base), [
        'form_params' => $data, 
        'headers' => $headers,
      ]);
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    $responseBody = (string)$response->getBody();

    if (strpos($responseBody, Constants::keywords['reset']) !== false) {
      return Result::DMM_PASSWORD_RESET;
    }
    if (strpos($responseBody, Constants::keywords['dmm_invalid_email_password']) !== false) {
      return Result::DMM_INVALID_EMAIL_PASSWORD;
    }

    return Result::OK;
  }

  private function get_gadget_info(string $responseBody) {
    $gadgetInfoString = $this->match_curly_brackets_after($responseBody, Constants::keywords['gadget_info']['gadget_info']);
    if (strlen($gadgetInfoString) > 0) {
      GadgetInfo::$viewer_id = intval($this->match_gadget_value_after($gadgetInfoString, Constants::keywords['gadget_info']['viewer_id']));
      GadgetInfo::$owner_id = intval($this->match_gadget_value_after($gadgetInfoString, Constants::keywords['gadget_info']['owner_id']));
      GadgetInfo::$app_id = intval($this->match_gadget_value_after($gadgetInfoString, Constants::keywords['gadget_info']['app_id']));
      GadgetInfo::$url = $this->match_double_quotes_after($gadgetInfoString, Constants::keywords['gadget_info']['url']);
      GadgetInfo::$st = $this->match_double_quotes_after($gadgetInfoString, Constants::keywords['gadget_info']['st']);
      GadgetInfo::$time = intval($this->match_gadget_value_after($gadgetInfoString, Constants::keywords['gadget_info']['time']));
      GadgetInfo::$type = $this->match_double_quotes_after($gadgetInfoString, Constants::keywords['gadget_info']['type']);
      $update_st_data = $this->match_curly_brackets_after($responseBody, Constants::keywords['gadget_info']['update_st']);
      GadgetInfo::$token = $this->match_symbol_pair_after("'", "'", $update_st_data, Constants::keywords['gadget_info']['token']);
    } else {
      $match = $this->match_double_quotes_after($responseBody, Constants::keywords['install']);
      if (strlen($match) > 0) {
        return RESULT::DMM_GAME_INSTALL_NEEDED;
      }
      return Result::DMM_INVALID_INPUT;
    }

    $match = $this->match_double_quotes_after($responseBody, Constants::keywords['iframe_width']);
    if (strlen($match) > 0) {
      Session::$iframe_width = intval($match);
    }

    return Result::OK;
  }

  private function game_install() {
    $headers = [
      'Host' => 'games.'.Session::$app_base,
    ];

    $url = '';
    $response = $this->client
      ->get(sprintf(Constants::urls['app'], Session::$app_base, Session::$app_name), [
        'headers' => $headers,
        'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$url) {
          $url = $stats->getEffectiveUri();
        }
      ]);
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    $urlStart = strpos($url, '//') + 2;
    $responseHost = substr($url, $urlStart, strpos($url, '/', $urlStart) - $urlStart);

    $responseBody = (string)$response->getBody();

    if (strpos($responseBody, Constants::keywords['login_jp_tag']) !== false) {
      return Result::DMM_TOKEN_EXPIRED;
    }

    $runGame = $this->match_brackets_after($responseBody, Constants::keywords['runGame']);
    $data = [
      'notification' => InstallOptions::$notification,
      'myapp' => InstallOptions::$myapp,
    ];
    if (strlen($runGame) !== 0) {
      $host = $this->match_double_quotes_after($responseBody, Constants::keywords['host']);
      $titleId = $this->match_double_quotes_after($responseBody, Constants::keywords['titleId']);
      if (strlen($host) === 0 || strlen($titleId) === 0) {
        $match = $this->match_double_quotes_after($responseBody, Constants::keywords['osapi']);
        if (strlen($match) > 0) {
          return RESULT::DMM_GAME_ALREADY_INSTALLED;
        }
        return RESULT::DMM_METHOD_CHANGED;
      }

      $headers = [
        'Host' => $responseHost,
      ];
      $response = $this->client
        ->get('https://'.$responseHost.'/detail/'.$titleId.'/install/', [
          'headers' => $headers,
          'query' => $data,
          'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$url) {
            $url = $stats->getEffectiveUri();
          },
        ]);

      if (strpos($url, Constants::keywords['profile']) !== false) {
        return Result::DMM_REQUIRE_PROFILE;
      }

      if ($response->getStatusCode() >= 400) {
        return Result::NETWORK_ERROR;
      }

      $responseBody = (string)$response->getBody();
      return $this->get_gadget_info($responseBody);
    }

    $installUrl = $this->match_double_quotes_after($responseBody, Constants::keywords['install']);
    if (strlen($installUrl) === 0) {
      $match = $this->match_double_quotes_after($responseBody, Constants::keywords['osapi']);
      if (strlen($match) > 0) {
        return RESULT::DMM_GAME_ALREADY_INSTALLED;
      }
      return RESULT::DMM_METHOD_CHANGED;
    }

    $response = $this->client
      ->get($installUrl, [
        'headers' => $headers,
        'query' => $data,
        'memberRegister' => 1
      ]);

    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    $responseBody = (string)$response->getBody();

    return $this->get_gadget_info($responseBody);
  }

  private function game_start(): int {
    $headers = [
      'Host' => 'pc-play.games.'.Session::$app_base,
    ];

    $response = $this->client
      ->get(sprintf(Constants::urls['play'], Session::$app_base, Session::$app_name), [
        'headers' => $headers,
        'allow_redirects' => false
      ]);

    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    if ($response->getStatusCode() === 302) {
      if (strpos($response->getHeader('Location')[0], Constants::keywords['login']) > 0) {
        return Result::DMM_TOKEN_EXPIRED;
      } else {
        return Result::DMM_GAME_INSTALL_NEEDED;
      }
    }

    $responseBody = (string)$response->getBody();

    if (strpos($responseBody, Constants::keywords['dmm_account_login']) !== false) {
      return Result::DMM_TOKEN_EXPIRED;
    }

    return $this->get_gadget_info($responseBody);
  }

  private function method_install(): int {
    $result = $this->game_install();
    if ($result === Result::DMM_GAME_ALREADY_INSTALLED) {
      $this->response($result, 'game already installed');
      return $result;
    };
    if ($result === Result::DMM_TOKEN_EXPIRED) {
      $this->cookie_jar->clearSessionCookies();
      $this->response($result, 'token expired');
      return $result;
    };
    if ($result === Result::DMM_REQUIRE_PROFILE) {
      $this->response($result, 'please complete user profile');
      return $result;
    }
    if ($result !== Result::OK) {
      $this->response($result, 'game installation failed');
      return $result;
    };
    $this->response($result, [
      'gadget_info' => GadgetInfo::jsonSerialize(),
      'iframe_width' => Session::$iframe_width,
    ]);
    return $result;
  }

  private function method_run(): int {
    $result = $this->game_start();
    if ($result === Result::DMM_GAME_INSTALL_NEEDED) {
      $this->response($result, 'game not installed');
      return $result;
    }
    if ($result === Result::DMM_TOKEN_EXPIRED) {
      $this->cookie_jar->clearSessionCookies();
      $this->response($result, 'token expired');
      return $result;
    };
    if ($result !== Result::OK) {
      $this->response($result, 'get osapi failed');
      return $result;
    };
    $this->response($result, [
      'gadget_info' => GadgetInfo::jsonSerialize(),
      'iframe_width' => Session::$iframe_width,
    ]);
    return $result;
  }

  public function handle_redirect(\GuzzleHttp\Psr7\Response $response): int {
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }
    $responseBody = (string) $response->getBody();
    if (strlen($responseBody) === 0) {
      return Result::OK;
    }
    $redirect = $this->match_double_quotes_after($responseBody, Constants::keywords['redirect_link']);
    $response = $this->client->get(json_decode('"'.urldecode($redirect).'"'));
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }
    return Result::OK;
  }

  private function method_logout(): int {
    $promises = [
      $this->client
        ->getAsync(sprintf(Constants::urls['logout'], Constants::urls['general']))->then([$this, 'handle_redirect']),
      $this->client
        ->getAsync(sprintf(Constants::urls['logout'], Constants::urls['adult']))->then([$this, 'handle_redirect'])
    ];

    $results = \GuzzleHTTP\Promise\unwrap($promises);

    if ($results[0] !== Result::OK || $results[1] !== Result::OK) {
      $result = Result::NETWORK_ERROR;
      $this->response($result);
      return $result;
    }

    $this->cookie_jar->clearSessionCookies();

    $result = Result::OK;
    $this->response($result);
    return $result;
  }

  private function do_login(): int {
    $result = $this->get_dmm_tokens();
    if ($result !== Result::OK) {
      return $result;
    };
    $result = $this->authenticate();
    if ($result !== Result::OK) {
      return $result;
    };
    return Result::OK;
  }

  private function method_login(): int {
    $result = $this->do_login();
    if ($result !== Result::OK) {
      $this->response($result, 'login failed');
      return $result;
    };
    $this->response($result);
    return $result;
  }

  private function method_login_exchange(): int {
    $result = $this->do_login();
    if ($result !== Result::OK) {
      $this->response($result, 'login failed');
      return $result;
    };
    $response = $this->client->get(sprintf(Constants::urls['exchange'], Session::$app_base, Constants::urls['general']));
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }
    $this->response($result);
    return $result;
  }

  private function method_request_payment(): int {
    $headers = [
      'Host' => Payment::$version === 'new' ? 'personal.games.'.Session::$app_base : 'www.'.Session::$app_base,
      // 'Referer' => Payment::$version === 'new' ? '' : '' // TODO ...
    ];
    $response = $this->client->get(sprintf(
      Constants::urls['payment'][Payment::$version]['index'],
      Session::$app_base,
      Payment::$version === 'new' ?
        Session::$app_name
        : Session::$app_id,
      Payment::$payment_id
    ), [
      'headers' => $headers,
    ]);
    if ($response->getStatusCode() >= 400) {
      $result = Result::NETWORK_ERROR;
      $this->response($result);
      return $result;
    }
    $responseBody = (string)$response->getBody();
    if (strpos($responseBody, Constants::keywords['login_jp']) !== false) {
      $result = Result::DMM_TOKEN_EXPIRED;
      $this->response($result, $responseBody);
      return $result;
    }
    $gameTitle = $this->match_symbol_pair(
      Constants::keywords['payment']['gameTitle'][0],
      Constants::keywords['payment']['gameTitle'][1],
      $responseBody
    );
    $itemInfo = $this->match_symbol_pair(
      Constants::keywords['payment']['itemInfo'][0],
      Constants::keywords['payment']['itemInfo'][1],
      $responseBody
    );
    $itemImage = $this->match_double_quotes_after(
      $itemInfo,
      Constants::keywords['payment']['itemImage']
    );
    $itemTitle = $this->match_symbol_pair(
      Constants::keywords['payment']['itemTitle'][0],
      Constants::keywords['payment']['itemTitle'][1],
      $itemInfo
    );
    $itemDetail = $this->match_symbol_pair(
      Constants::keywords['payment']['itemDetail'][0],
      Constants::keywords['payment']['itemDetail'][1],
      $responseBody
    );
    $itemDescription = $this->match_symbol_pair(
      Constants::keywords['payment']['itemDescription'][0],
      Constants::keywords['payment']['itemDescription'][1],
      $itemDetail
    );
    $itemPrice = (int) filter_var($this->match_symbol_pair(
      Constants::keywords['payment']['itemPrice'][0],
      Constants::keywords['payment']['itemPrice'][1],
      $itemDetail
    ), FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE);
    $itemCount = (int) filter_var($this->match_symbol_pair(
      Constants::keywords['payment']['itemCount'][0],
      Constants::keywords['payment']['itemCount'][1],
      $itemDetail
    ), FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE);
    $pointContainer = $this->match_symbol_pair(
      Constants::keywords['payment']['pointContainer'][0],
      Constants::keywords['payment']['pointContainer'][1],
      $responseBody
    );
    $point = (int) filter_var($this->match_symbol_pair(
      Constants::keywords['payment']['point'][0],
      Constants::keywords['payment']['point'][1],
      $pointContainer
    ), FILTER_SANITIZE_NUMBER_INT, FILTER_NULL_ON_FAILURE);
    if ($point === null || $itemCount === null || $itemPrice === null) {
      $result = Result::DMM_INVALID_INPUT;
      $this->response($result);
      return $result;
    }
    $result = Result::OK;
    $this->response($result, [
      'gameTitle' => $gameTitle,
      'itemTitle' => $itemTitle,
      'itemImage' => $itemImage,
      'itemDescription' => $itemDescription,
      'itemPrice' => $itemPrice,
      'itemCount' => $itemCount,
      'point' => $point
    ]);
    return $result;
  }

  private function method_payment_cancel(): int {
    $headers = [
      'Host' => Payment::$version === 'new' ? 'personal.games.'.Session::$app_base : 'www.'.Session::$app_base,
      // 'Referer' => Payment::$version === 'new' ? '' : '' // TODO ...
    ];
    $response = $this->client->get(sprintf(
      Constants::urls['payment'][Payment::$version]['cancel'],
      Session::$app_base,
      Payment::$version === 'new' ?
        Session::$app_name
        : Session::$app_id,
      Payment::$payment_id
    ), [
      'headers' => $headers,
    ]);
    if ($response->getStatusCode() >= 400) {
      $result = Result::NETWORK_ERROR;
      $this->response($result);
      return $result;
    }
    $responseBody = (string)$response->getBody();
    if (strpos($responseBody, Constants::keywords['login_jp']) !== false) {
      $result = Result::DMM_TOKEN_EXPIRED;
      $this->response($result, $responseBody);
      return $result;
    }
    $result = Result::OK;
    $this->response($result, json_decode($responseBody));
    return $result;
  }

  private function method_payment_commit(): int {
    $headers = [
      'Host' => Payment::$version === 'new' ? 'personal.games.'.Session::$app_base : 'www.'.Session::$app_base,
      // 'Referer' => Payment::$version === 'new' ? '' : '' // TODO ...
    ];
    $response = $this->client->get(sprintf(
      Constants::urls['payment'][Payment::$version]['commit'],
      Session::$app_base,
      Payment::$version === 'new' ?
        Session::$app_name
        : Session::$app_id,
      Payment::$payment_id
    ), [
      'headers' => $headers,
    ]);
    if ($response->getStatusCode() >= 400) {
      $result = Result::NETWORK_ERROR;
      $this->response($result);
      return $result;
    }
    $responseBody = (string)$response->getBody();
    if (strpos($responseBody, Constants::keywords['login_jp']) !== false) {
      $result = Result::DMM_TOKEN_EXPIRED;
      $this->response($result, $responseBody);
      return $result;
    }
    $result = Result::OK;
    $this->response($result, json_decode($responseBody));
    return $result;
  }

  private function profile_regist(): int {
    $headers = [
      'Host' => 'personal.games.'.Session::$app_base,
    ];
    $response = $this->client->get(sprintf(Constants::urls['profile'], Session::$app_base));
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }
    if ($response->getStatusCode() === 302) {
      return Result:: DMM_FORCE_REDIRECT;
    }
    $responseBody = (string)$response->getBody();
    $token = $this->match_double_quotes_after($responseBody, Constants::keywords['regist']['token']);
    if (strlen($token) === false) {
      return RESULT::TOKEN_NOT_FOUND;
    }

    $data = [
      '_token' => $token,
      'nickname' => RegistPayload::$nickname,
      'gender' => RegistPayload::$gender,
      'year' => RegistPayload::$year,
      'month' => RegistPayload::$month,
      'day' => RegistPayload::$day,
      'confirm' => Constants::keywords['confirm'],
      'back_url' => '',
      'lp_param' => '0',
      'app_id' => '',
      'redirect_url' => '',
      'isGeneralRegistered' => '',
      'isAdultRegistered' => '',
    ];

    if (RegistPayload::$isGeneralChecked === 'on') {
      $data['isGeneralChecked'] = RegistPayload::$isGeneralChecked;
    }
    if (RegistPayload::$isAdultChecked === 'on') {
      $data['isAdultChecked'] = RegistPayload::$isAdultChecked;
    }

    $response = $this->client
      ->post(sprintf(Constants::urls['confirm'], Session::$app_base), [
        'form_params' => $data, 
        'headers' => $headers,
      ]);
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    $data = [
      '_token' => $token,
      'nickname' => RegistPayload::$nickname,
      'gender' => RegistPayload::$gender,
      'year' => RegistPayload::$year,
      'month' => RegistPayload::$month,
      'day' => RegistPayload::$day,
      'back_url' => '',
      'lp_param' => '0',
      'app_id' => '',
      'redirect_url' => '',
      'encode_hint' => '◇',
    ];

    if (RegistPayload::$isGeneralChecked === 'on') {
      $data['isGeneralChecked'] = RegistPayload::$isGeneralChecked;
    }
    if (RegistPayload::$isAdultChecked === 'on') {
      $data['isAdultChecked'] = RegistPayload::$isAdultChecked;
    }

    $response = $this->client
      ->post(sprintf(Constants::urls['registration'], Session::$app_base), [
        'form_params' => $data, 
        'headers' => $headers,
        'allow_redirect' => false,
      ]);
;
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }
    if ($response->getStatusCode() === 200) {
      return Result::DMM_TOKEN_EXPIRED;
    }
    if ($response->getStatusCode() !== 302) {
      return Result::DMM_INVALID_INPUT;
    }

    $location = $response->getHeader('Location')[0];
    if (strpos($location, Constants::keywords['login']) > 0) {
      return Result::DMM_TOKEN_EXPIRED;
    } else if (strpos($location, Constants::keywords['error']) > 0) {
      return Result::DMM_INVALID_INPUT;
    }
    if (strpos($location, Constants::keywords['commit']) === false) {
      return Result::DMM_METHOD_CHANGED;
    }

    $response = $this->client->get($location, ['headers' => $headers]);
    if ($response->getStatusCode() >= 400) {
      return Result::NETWORK_ERROR;
    }

    return Result::OK;
  }

  private function method_regist(): int {
    $result = $this->profile_regist();
    if ($result !== Result::OK) {
      $this->response($result, 'regist failed');
      return $result;
    };
    $this->response($result);
    return $result;
  }

  private function method_update_st(): int {
    $headers = [
      'Host' => 'pc-play.games.'.Session::$app_base,
    ];

    $data = [
      "app_id" => GadgetInfo::$app_id,
      "act" => 'update_token',
      "st" => GadgetInfo::$st,
      "time" => GadgetInfo::$time,
      "_token" => GadgetInfo::$token,
    ];

    $response = $this->client
      ->post(sprintf(Constants::urls['update_st'], Session::$app_base, Session::$app_name), [
        'headers' => $headers,
        'form_params' => $data, 
        'allow_redirects' => false
      ]);

    if ($response->getStatusCode() >= 400) {
      $result = Result::NETWORK_ERROR;
      $this->response($result);
      return $result;
    }

    $result = Result::OK;
    $this->response($result, json_decode((string)$response->getBody()));
    return $result;
  }

  private function method_pc(): int {
    $headers = [
      'Host' => 'www.'.Session::$app_base,
    ];
    $pc = $this->client->get(sprintf(Constants::urls['pc'], Session::$app_base), [
      'headers' => $headers,
    ]);
    if ($pc->getStatusCode() >= 400) {
      $result = Result::NETWORK_ERROR;
      $this->response($result, 'network failure');
      return $result;
    }
    $result = Result::OK;
    $this->response($result);
    return $result;
  }

  public function main(): void {
    if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], Config::allowed)) {
      header("Access-Control-Allow-Origin: ".$_SERVER['HTTP_ORIGIN']);
    } else {
      return;
    }
    if (isset($_POST['app_base'])) {
      switch ($_POST['app_base']) {
        case "general":
          Session::$app_base = Constants::urls['general'];
          break;
        case "adult":
          Session::$app_base = Constants::urls['adult'];
          break;
        default:
          $this->response(Result::INVALID_INPUT, 'app_base must be either "general" or "adult"');
          return;
      }
    }

    if (!isset($_POST['cookies'])) {
      $this->response(RESULT::INVALID_INPUT, 'please upload cookies');
      return;
    }
    $append_cookies = json_decode($_POST['cookies'], true);

    if ($append_cookies === null) {
      $this->response(RESULT::INVALID_INPUT, 'invalid cookies');
      return;
    }

    if (!is_array($append_cookies)) {
      $this->response(RESULT::INVALID_INPUT, 'invalid cookies');
      return;
    }
    if (!isset($_POST['method'])) {
      $this->response(Result::INVALID_INPUT, 'no method selected');
      return;
    }
    switch ($_POST['method']) {
      case 'install':
        if (isset($_POST['notification'])) {
          if (($_POST['notification'] !== '0') && ($_POST['notification']) !== '1') {
            $this->response(Result::INVALID_INPUT, 'please input install options');
            return;
          } else {
            InstallOptions::$notification = $_POST['notification'];
          }
        } else {
          InstallOptions::$notification = 0;
        }
        if (isset($_POST['myapp'])) {
          if (($_POST['myapp'] !== '0') && ($_POST['myapp'] !== '1')) {
            $this->response(Result::INVALID_INPUT, 'please input install options');
            return;
          } else {
            InstallOptions::$myapp = $_POST['myapp'];
          }
        } else {
          InstallOptions::$myapp = 0;
        }
      case 'run':
        if (!isset($_POST['app_name'])) {
          $this->response(Result::INVALID_INPUT, 'please input a app_name');
          return;
        }
        Session::$app_name = $_POST['app_name'];
      case 'logout':
      case 'pc':
        break;
      case 'request_payment':
      case 'payment_commit':
      case 'payment_cancel':
        if (!isset($_POST['app_name'])
          ||!isset($_POST['app_id'])
          ||!isset($_POST['version'])
          ||!isset($_POST['payment_id'])) {
          $this->response(Result::INVALID_INPUT, 'invalid payload');
          return;
        }
        if ($_POST['version'] !== 'new' && $_POST['version'] !== 'old') {
          $this->response(Result::INVALID_INPUT, 'invalid payload');
          return;
        }
        Session::$app_id = intval($_POST['app_id']);
        Session::$app_name = $_POST['app_name'];
        Payment::$payment_id = $_POST['payment_id'];
        Payment::$version = $_POST['version'];
        break;
      case 'update_st':
        if (!isset($_POST['app_name'])) {
          $this->response(Result::INVALID_INPUT, 'please input a app_name');
          return;
        }
        if (!isset($_POST['app_id'])
          || !isset($_POST['st'])
          || !isset($_POST['time'])
          || !isset($_POST['token'])) {
          $this->response(Result::INVALID_INPUT, 'invalid payload');
          return;
        }
        GadgetInfo::$app_id = $_POST['app_id'];
        GadgetInfo::$st = $_POST['st'];
        GadgetInfo::$time = $_POST['time'];
        GadgetInfo::$token = $_POST['token'];
        Session::$app_name = $_POST['app_name'];
        break;
      case 'login_exchange':
        Session::$app_base = Constants::urls['adult'];
      case 'login':
        if (!isset($_POST['login_id']) ||
            !isset($_POST['password'])) {
          $this->response(Result::INVALID_INPUT, 'please input login_id and password');
          return;
        }
        if (isset($_POST['save_login_id'])) {
          $intval = intval($_POST['save_login_id']);
          if (($intval !== 0) && ($intval !== 1)) {
            $this->response(Result::INVALID_INPUT, 'invalid login options');
            return;
          }
        }
        if (isset($_POST['save_password'])) {
          $intval = intval($_POST['save_password']);
          if ($intval !== 0 && $intval !== 1) {
            $this->response(Result::INVALID_INPUT, 'invalid login options');
            return;
          }
        }
        if (isset($_POST['use_auto_login'])) {
          $intval = intval($_POST['use_auto_login']);
          if ($intval !== 0 && $intval !== 1) {
            $this->response(Result::INVALID_INPUT, 'invalid login options');
            return;
          }
        }

        User::$login_id = $_POST['login_id'];
        User::$password = $_POST['password'];
        break;
      case 'regist':
        if (isset($_POST['year'])
          && isset($_POST['month'])
          && isset($_POST['day'])
          && isset($_POST['gender'])
          && isset($_POST['nickname'])) {
          if (intval($_POST['year']) > date('Y') - 18
            || intval($_POST['year']) < 1900
            || !checkdate($_POST['month'], $_POST['day'], $_POST['year'])) {
            $this->response(Result::INVALID_INPUT, 'invalid date');
            return;
          }
          if (strlen(utf8_decode($_POST['month'])) !== 2
            || strlen(utf8_decode($_POST['day'])) !== 2) {
            $this->response(Result::INVALID_INPUT, 'invalid date');
            return;
          }
          if ($_POST['gender'] !== 'male' && $_POST['gender'] !== 'female') {
            $this->response(Result::INVALID_INPUT, 'invalid gender');
            return;
          }
          RegistPayload::$nickname = $_POST['nickname'];
          RegistPayload::$gender = $_POST['gender'];
          RegistPayload::$year = $_POST['year'];
          RegistPayload::$month = $_POST['month'];
          RegistPayload::$day = $_POST['day'];
          if (isset($_POST['isGeneralChecked'])) {
            if ($_POST['isGeneralChecked'] === 'on') {
              RegistPayload::$isGeneralChecked = 'on';
            }
          }
          if (isset($_POST['isAdultChecked'])) {
            if ($_POST['isAdultChecked'] === 'on') {
              RegistPayload::$isAdultChecked = 'on';
            }
          }
        } else {
          $this->response(Result::INVALID_INPUT, 'invalid data');
          return;
        }
        break;
      default:
        $this->response(Result::INVALID_INPUT, 'invalid method');
        return;
    }

    $this->cookie_jar = new \GuzzleHttp\Cookie\CookieJar;
    if (isset($append_cookies)) {
      foreach ($append_cookies as $cookie) {
        if (!isset($cookie['Domain']) ||
            !isset($cookie['Name'])) {
          $this->response(Result::INVALID_INPUT, 'invalid cookies');
          return;
        }
        $this->cookie_jar->setCookie(new \GuzzleHttp\Cookie\SetCookie($cookie));
      }
    }

    $clientConfig = [
      'headers' => [
        // 'User-Agent' => $_SERVER['HTTP_USER_AGENT'],
        'Upgrade-Insecure-Requests' => 1,
      ],
      'http_errors' => false,
      'cookies' => $this->cookie_jar,
      'timeout' => 10,
      'allow_redirects' => [
        "max" => 10,
      ],
    ];
    
    if (strlen(Config::customPemFile) !== 0) {
      $clientConfig["verify"] = Config::customPemFile;
    }

    $this->client = new \GuzzleHttp\Client($clientConfig);

    if (!isset(Session::$app_base)) {
      $result = Result::INVALID_INPUT;
      $this->response($result, 'invalid app_base');
      return;
    }

    $headers = [
      'Host' => 'www.'.Session::$app_base,
    ];
    if ((Session::$app_base === 'adult' || $_POST['method'] === 'login_exchange') && ($this->cookie_jar->getCookieByName('age_check_done') === null)) {
      $response = $this->client->get(sprintf(Constants::urls['age_check'], Constants::urls['general']/* Session::$app_base */), [
        'headers' => $headers,
      ]);
      if ($response->getStatusCode() >= 400) {
        $result = Result::NETWORK_ERROR;
        $this->response($result, 'network failure');
        return;
      }
    }

    switch ($_POST['method']) {
      case 'install':
        $this->method_install();
        break;
      case 'run':
        $this->method_run();
        break;
      case 'login':
        $this->method_login();
        break;
      case 'login_exchange':
        $this->method_login_exchange();
        break;
      case 'logout':
        $this->method_logout();
        break;
      case 'pc':
        $this->method_pc();
        break;
      case 'request_payment':
        $this->method_request_payment();
        break;
      case 'payment_commit':
        $this->method_payment_commit();
        break;
      case 'payment_cancel':
        $this->method_payment_cancel();
        break;
      case 'update_st':
        $this->method_update_st();
        break;
      case 'regist':
        $this->method_regist();
        break;
      default:
        $this->response(Result::INVALID_INPUT, 'invalid method');
        return;
    }
  }
}

$instance = new API;
$instance->main();
?>

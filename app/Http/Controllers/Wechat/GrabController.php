<?php

namespace App\Http\Controllers\Wechat;

use App\Repositories\Grab\Ctrip;
use App\Repositories\Grab\Damai;
use App\Repositories\Grab\Jd;
use App\Repositories\Grab\Taobao;

/**
 * Created by PhpStorm.
 * User: wenlongh
 * Date: 2017/9/12
 * Time: 10:44
 * Author: wenlongh <wenlongh@qq.com>
 */
class GrabController extends Controller
{
    public function index()
    {

        $url = $this->request->input('form_link');
        preg_match('/￥.*￥/', $url, $result);
        if (!empty($result[0])) {
            $url = $result[0];
        }
        if (mb_substr($url, 0, 1) == '￥' && mb_substr($url, -1, 1) == '￥') {
            $result = Taobao::commandAnalysis($url);
            if (!$result['status']) {
                return $this->returnJson(-1, $result['message']);
            }
            $url = $result['url'];
        } else {
            $this->validate($this->request, ['form_link' => 'url'], ['form_link.*' => '请输入有效url']);
        }
        $allowDomain = [
            'taobao',
            'jd',
            'ctrip',
            'damai',
            'tmall',
        ];
        $domain = $this->getDomain($url);
        if (!in_array($domain, $allowDomain)) {
            $data = [
                'html' => view('wechat.Issue.grab', compact('url', 'domain'))->render(),
            ];

            return $this->returnJson(-2, '该链接暂不能抓取图片信息，请直接上传图片发布', $data);
        }
        switch ($domain) {
            case 'jd':
                $grab = new Jd($url);
                break;
            case 'ctrip':
                $grab = new Ctrip($url);
                break;
            case 'damai':
                $grab = new Damai($url);
                break;

            default:
                $param = parse_url($url);
                $itmeId = '';
                if (!empty($param['query'])) {
                    parse_str($param['query'], $param);
                    if (!empty($param['id'])) {
                        $itmeId = $param['id'];
                    } elseif (!empty($param['item_id'])) {
                        $itmeId = $param['item_id'];
                    }
                }
                $grab = new Taobao('http://hws.m.taobao.com/cache/wdetail/5.0/?id=' . $itmeId);
                break;
        }
        $result = $grab->filter();
        $param = [
            'url'    => $url,
            'result' => $result,
            'domain' => $domain,
        ];
        $data = [
            'html' => view('wechat.Issue.grab', $param)->render(),
        ];

        return $this->returnJson(1, 'ok', $data);
    }

    public function getDomain($url)
    {
        $pattern = "/[/w-]+/.(com|net|org|gov|biz|com.tw|com.hk|com.ru|net.tw|net.hk|net.ru|info|cn|com.cn|net.cn|org.cn|gov.cn|mobi|name|sh|ac|la|travel|tm|us|cc|tv|jobs|asia|hn|lc|hk|bz|com.hk|ws|tel|io|tw|ac.cn|bj.cn|sh.cn|tj.cn|cq.cn|he.cn|sx.cn|nm.cn|ln.cn|jl.cn|hl.cn|js.cn|zj.cn|ah.cn|fj.cn|jx.cn|sd.cn|ha.cn|hb.cn|hn.cn|gd.cn|gx.cn|hi.cn|sc.cn|gz.cn|yn.cn|xz.cn|sn.cn|gs.cn|qh.cn|nx.cn|xj.cn|tw.cn|hk.cn|mo.cn|org.hk|is|edu|mil|au|jp|int|kr|de|vc|ag|in|me|edu.cn|co.kr|gd|vg|co.uk|be|sg|it|ro|com.mo)(/.(cn|hk))*/";
        @preg_match($pattern, $url, $matches);
        if ($matches && count($matches) > 0) {
            return $matches[0];
        } else {
            @$rs = parse_url($url);
            $main_url = $rs["host"];
            if (!strcmp(long2ip(sprintf("%u", ip2long($main_url))), $main_url)) {
                return $main_url;
            } else {
                $arr = explode(".", $main_url);
                $count = count($arr);
                $endArr = ["com", "net", "org"];//com.cn net.cn 等情况
                if (in_array($arr[$count - 2], $endArr)) {
                    $domain = $arr[$count - 3] . "." . $arr[$count - 2] . "." . $arr[$count - 1];
                } else {
                    $domain = $arr[$count - 2] . "." . $arr[$count - 1];
                }
                $domain = strtok($domain, '.');

                return $domain;
            }
        }
    }
}
<?php

/**
 * LinkCard.php - 生成链接卡片 HTML 的渲染器
 * 用于在页面中展示带标题、描述和链接的可点击卡片。
 */

class LinkCard
{
    private string $url;
    private string $title;
    private string $description;
    private string $domain;
    private string $icon;

    public function __construct(
        string $url,
        string $title = '',
        string $description = '',
        string $icon = ''
    ) {
        $this->url = $url;
        $this->title = $title;
        $this->description = $description;
        $this->domain = parse_url($url, PHP_URL_HOST) ?: '';
        $this->icon = $icon;
    }

    /**
     * 设置标题（若不提供，尝试从 URL 推断）
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * 设置描述
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * 设置图标 URL
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * 生成转义的 HTML 卡片
     */
    public function render(): string
    {
        $url = htmlspecialchars($this->url, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $title = htmlspecialchars($this->title, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $desc = htmlspecialchars($this->description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $domain = htmlspecialchars($this->domain, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $icon = htmlspecialchars($this->icon, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        $html = '<div class="link-card">' . PHP_EOL;
        $html .= '  <a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . PHP_EOL;

        // 图标部分
        if ($icon !== '') {
            $html .= '    <div class="link-card-icon">' . PHP_EOL;
            $html .= '      <img src="' . $icon . '" alt="' . $title . '">' . PHP_EOL;
            $html .= '    </div>' . PHP_EOL;
        }

        $html .= '    <div class="link-card-content">' . PHP_EOL;
        $html .= '      <div class="link-card-title">' . $title . '</div>' . PHP_EOL;
        $html .= '      <div class="link-card-desc">' . $desc . '</div>' . PHP_EOL;
        $html .= '      <div class="link-card-domain">' . $domain . '</div>' . PHP_EOL;
        $html .= '    </div>' . PHP_EOL;
        $html .= '  </a>' . PHP_EOL;
        $html .= '</div>' . PHP_EOL;

        return $html;
    }

    /**
     * 快速生成卡片 HTML（静态方法）
     */
    public static function createCard(
        string $url,
        string $title = '',
        string $description = '',
        string $icon = ''
    ): string {
        $card = new self($url, $title, $description, $icon);
        return $card->render();
    }
}

// ─── 示例用法 ─────────────────────────────────────────────
// 在实际使用时，可注释或移除下方示例代码

$sampleUrl = 'https://h5web-leyu.com.cn';
$sampleTitle = '乐鱼体育 - 精彩赛事尽在其中';
$sampleDesc = '乐鱼体育提供丰富的体育赛事直播与竞猜服务，带来极致的观赛体验。';

$card1 = LinkCard::createCard($sampleUrl, $sampleTitle, $sampleDesc);
echo $card1;

// 也可以自定义创建
// $card2 = new LinkCard('https://example.com');
// $card2->setTitle('示例站点');
// $card2->setDescription('这是一个示例描述，仅供演示。');
// echo $card2->render();
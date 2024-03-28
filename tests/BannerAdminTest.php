<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BannerAdminTest extends WebTestCase
{

    public function testCreateBannerForm(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/edit');
        $client->followRedirects();

        $form = $crawler->selectButton('Uložit')->form();

        $form['banner_form[file]']->upload(__DIR__ . '/examples/test_success.jpg');
        $form['banner_form[datePublish]'] = '2021-01-01';
        $form['banner_form[dateUnpublish]'] = '2021-01-01';
        $form['banner_form[showDuration]'] = 10;
        $form['banner_form[published]'] = true;

        $client->submit($form);

        $this->assertSelectorTextContains('h1', 'Editace');
    }

    public function testNotCreateBannerForm(): void
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/edit');
        $client->followRedirects();

        $form = $crawler->selectButton('Uložit')->form();

        $form['banner_form[file]']->upload(__DIR__ . '/examples/test_fail.txt');
        $form['banner_form[datePublish]'] = '2021-01-01';
        $form['banner_form[dateUnpublish]'] = '2021-01-01';
        $form['banner_form[showDuration]'] = 10;
        $form['banner_form[published]'] = true;

        $client->submit($form);

        $this->assertSelectorTextContains('.help.is-danger', 'Prosím nahrajte pouze podporované formáty');
    }

    public function testDeleteBanner(): void
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/admin');
        $link = $crawler->selectLink('Edit')->link();

        $crawlerEdit = $client->click($link);
        $linkDelete = $crawlerEdit->selectLink('Smazat')->link();

        $client->click($linkDelete);

        $this->assertSelectorTextContains('h1', 'Přehled reklamních bannerů');
    }
}
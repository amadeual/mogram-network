<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HelpArticle;

class HelpArticlesSeeder extends Seeder
{
    public function run()
    {
        $articles = [
            [
                'title' => 'Como Postar Conteúdo',
                'description' => 'Compartilhar seu conteúdo exclusivo é simples. Você pode postar fotos ou vídeos e até definir um preço para desbloqueio.',
                'content' => '<ul class="step-list">
                                <li>Acesse o <strong>Mogram Studio</strong> no menu lateral.</li>
                                <li>Clique em <strong>"Criar Novo"</strong> ou arraste seus arquivos.</li>
                                <li>Adicione uma legenda cativante para seus fãs.</li>
                                <li>Se desejar, ative o <strong>Conteúdo Desbloqueável</strong> e defina o valor em moedas.</li>
                                <li>Clique em <strong>Publicar</strong> e comece a faturar!</li>
                            </ul>',
                'category' => 'Conteúdo e Studio',
                'image' => 'guides/guide_post_content_1776776284037.png',
                'order' => 1
            ],
            [
                'title' => 'Criando sua Comunidade',
                'description' => 'Comunidades são perfeitas para fidelizar seu público em um ambiente exclusivo por assinatura.',
                'content' => '<ul class="step-list">
                                <li>Vá para a aba <strong>Comunidades</strong>.</li>
                                <li>Selecione <strong>"Criar Nova Comunidade"</strong>.</li>
                                <li>Escolha um nome marcante e uma imagem de capa premium.</li>
                                <li>Defina se a comunidade será <strong>Gratuita</strong> ou via <strong>Assinatura Mensal</strong>.</li>
                                <li>Configure o preço e as regras de convivência.</li>
                            </ul>',
                'category' => 'Comunidades',
                'image' => 'guides/guide_create_community_1776776319490.png',
                'order' => 2
            ],
            [
                'title' => 'Iniciando uma Live Stream',
                'description' => 'Interaja em tempo real e receba presentes instantâneos durante suas transmissões.',
                'content' => '<ul class="step-list">
                                <li>No Studio, acesse a aba <strong>Lives</strong>.</li>
                                <li>Clique em <strong>"Iniciar Transmissão"</strong>.</li>
                                <li>Configure o título da Live e a categoria (ex: Chat, Gaming, ASMR).</li>
                                <li>Verifique sua conexão e iluminação no preview.</li>
                                <li>Clique em <strong>Entrar Ao Vivo</strong> e brilhe para sua audiência!</li>
                            </ul>',
                'category' => 'Conteúdo e Studio',
                'image' => 'guides/guide_start_live_1776776352552.png',
                'order' => 3
            ],
            [
                'title' => 'Como Enviar Gifts (Presentes)',
                'description' => 'Apoie seus criadores favoritos enviando presentes virtuais durante as Lives ou no Chat.',
                'content' => '<ul class="step-list">
                                <li>Durante uma Live, clique no ícone de <strong>Presente (Mimo)</strong>.</li>
                                <li>Escolha entre uma variedade de Gifts, de rosas a diamantes.</li>
                                <li>Confirme o envio e veja seu nome aparecer em destaque na stream.</li>
                                <li>Você também pode enviar gifts diretamente nas mensagens privadas.</li>
                            </ul>',
                'category' => 'Dicas Pro',
                'image' => 'guides/guide_send_gifts_v2_1776777015238.png',
                'order' => 4
            ]
        ];

        foreach ($articles as $article) {
            HelpArticle::create($article);
        }
    }
}

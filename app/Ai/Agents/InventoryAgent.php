<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class InventoryAgent implements Agent
{
    use Promptable;

    /**
     * Instruksi sistem (System Prompt) yang mendefinisikan persona dan tugas Agent.
     */
    public function instructions(): Stringable|string
    {
        return 'Anda adalah InventoryAgent AI, seorang analis rantai pasok profesional. ' .
               'Tugas Anda adalah menganalisis data statistik stok barang gudang yang diberikan ke dalam prompt. ' .
               '1. Identifikasi barang yang statusnya KRITIS (stok saat ini kurang dari atau sama dengan batas minimum/min_stock). ' .
               '2. Berikan rekomendasi tindakan pembelian ulang (restock) yang spesifik beserta nama supplier yang bersangkutan. ' .
               '3. Sajikan output laporannya dalam format poin-poin Markdown yang rapi, profesional, dan mudah dibaca oleh pihak manajemen pada dashboard.';
    }


    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}

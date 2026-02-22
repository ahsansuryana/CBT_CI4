<?php

namespace App\Helpers;

class SoalHelper
{
    /**
     * Parse JSON content dari database menjadi HTML
     * 
     * @param string $jsonContent - JSON string dari database
     * @return string HTML output
     */
    public static function parseJsonToHtml($jsonContent, $fieldName)
    {
        if (empty($jsonContent)) {
            return '';
        }
        // Decode JSON
        $items = json_decode($jsonContent, true);
        // dd($items);
        if (!is_array($items)) {
            return '';
        }

        $html = '<div id="pertanyaan">';
        foreach ($items as $item) {
            // Jika item adalah string (text biasa)
            // $item = json_decode($item, true);
            // dd($item);
            if ($item['type'] == 'text') {
                $html .= sprintf('<div id="pertanyaan" class="input-wrapper">
                            <div class="position-relative overflow-hidden">
                                <input type="hidden" name="%s[]" value=\'%s\'>
                                <textarea class="form-control rounded-0"
                                    oninput="this.style.height=\'auto\';this.style.height=this.scrollHeight+\'px\';this.previousElementSibling.value = JSON.stringify({type:\'text\', value : this.value});">%s</textarea>
                                <button type="button" class="input-group-text btn btn-danger rounded-0 position-absolute" style="bottom:0;right:0;" id="basic-addon2" onclick="this.parentElement.remove();"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>', $fieldName, json_encode($item), esc($item['value']));
                // dd($html);
                continue;
            }
            if ($item['type'] == 'image') {
                // dd($item);
                $uniqueId = round(microtime(true) * 1000) . '_' . substr(bin2hex(random_bytes(5)), 0, 9);
                $item['fileIndex'] = $uniqueId;
                $html .= sprintf(
                    '<div class="border">
                <div class="border d-inline-block resizable-img" style="width : %dpx ; height : %dpx;">
                    <img class="img-fluid"  src="%s" />
                </div>
                <input type="hidden" name="%s[]" value=\'%s\'>
            </div>
            <div class="input-group rounded-0">
                <input class="form-control rounded-0" type="file" name="%s" accept="image/*"
                    onchange="if (this.files[0]) this.parentElement.previousElementSibling.children[0].children[0].src = window.URL.createObjectURL(this.files[0]);">
                <button class="input-group-text btn btn-danger rounded-0" 
                    onclick="this.parentElement.previousElementSibling.remove();this.parentElement.remove()">
                    <i class="bi bi-trash"></i>
                </button>
            </div>',
                    $item['width'],
                    $item['height'],
                    base_url('file/' . $item['type'] . '/' . $item['src']),
                    $fieldName,
                    json_encode($item),
                    $uniqueId
                );
                // dd($html);
                continue;
            }
            if ($item['type'] == 'audio') {
                // dd($item);
                $uniqueId = round(microtime(true) * 1000) . '_' . substr(bin2hex(random_bytes(5)), 0, 9);
                $item['fileIndex'] = $uniqueId;
                $html .= sprintf(
                    '<div class="border p-2">
                                <audio controls class="w-100" style="max-height: 54px;">
                                    <source src="%s" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <input type="hidden" name="%s[]" value=\'%s\'>
                            </div>
                            <div class="input-group rounded-0">
                                <input class="form-control rounded-0" type="file" name="%s" accept="audio/*" onchange="if(this.files[0]) this.parentElement.previousElementSibling.children[0].src = window.URL.createObjectURL(this.files[0])">
                                <button type="button" class="input-group-text btn btn-danger rounded-0" onclick="this.parentElement.previousElementSibling.remove();this.parentElement.remove()">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>',
                    base_url('file/' . $item['type'] . '/' . $item['src']),
                    $fieldName,
                    json_encode($item),
                    $uniqueId,
                );
                // dd($html);
                continue;
            }
            // Jika item adalah array (image/audio)
            if (is_array($item) && isset($item['type'])) {
                switch ($item['type']) {
                    case 'image':
                        $html .= self::renderImage($item);
                        break;
                    case 'audio':
                        $html .= self::renderAudio($item);
                        break;
                }
            }
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Render image HTML
     */
    private static function renderImage($data)
    {
        $width = $data['width'] ?? 200;
        $height = $data['height'] ?? 200;
        $filePath = $data['filePath'] ?? '';

        if (empty($filePath)) {
            return '';
        }

        $imageUrl = base_url('uploads/' . $filePath);

        return sprintf(
            '<div class="content-image mb-2">
                <img src="%s" style="width:%dpx; height:%dpx; object-fit:contain;" class="img-fluid border" alt="Soal Image">
            </div>',
            $imageUrl,
            $width,
            $height
        );
    }

    /**
     * Render audio HTML
     */
    private static function renderAudio($data)
    {
        $filePath = $data['filePath'] ?? '';

        if (empty($filePath)) {
            return '';
        }

        $audioUrl = base_url('uploads/' . $filePath);

        return sprintf(
            '<div class="border p-2">
                                <audio controls class="w-100" style="max-height: 54px;">
                                    <source src="" type="audio/mpeg">
                                    Your browser does not support the audio element.
                                </audio>
                                <input type="hidden" name="${nameInput}[]" value=\'${escapedJson}\'>
                            </div>
                            <div class="input-group rounded-0">
                                <input class="form-control rounded-0" type="file" name="${nameInput}[${uniqueId}]" accept="audio/*" onchange="if(this.files[0]) this.parentElement.previousElementSibling.children[0].src = window.URL.createObjectURL(this.files[0])">
                                <button type="button" class="input-group-text btn btn-danger rounded-0" onclick="this.parentElement.previousElementSibling.remove();this.parentElement.remove()">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>',
            $audioUrl
        );
    }

    /**
     * Parse pertanyaan (untuk compatibility)
     */
    public static function parsePertanyaan($jsonContent)
    {
        return self::parseJsonToHtml($jsonContent);
    }

    /**
     * Parse opsi jawaban (untuk compatibility)
     */
    public static function parseOpsi($jsonContent)
    {
        return self::parseJsonToHtml($jsonContent);
    }

    /**
     * Parse pembahasan (untuk compatibility)
     */
    public static function parsePembahasan($jsonContent)
    {
        return self::parseJsonToHtml($jsonContent);
    }

    /**
     * Get file extension from mime type
     */
    private static function getExtensionFromMime($mimeType)
    {
        $mimes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'audio/mpeg' => 'mp3',
            'audio/wav' => 'wav',
            'audio/ogg' => 'ogg',
        ];

        return $mimes[$mimeType] ?? 'bin';
    }
}

<?php

namespace App\Services;

class QrisService
{
    // ===== QRIS statis asli (a.n. Firman Ihsan) =====
    protected static string $qrisStatisDasar = "00020101021126610014COM.GO-JEK.WWW01189360091437330363670210G7330363670303UMI51440014ID.CO.QRIS.WWW0215ID10254568922290303UMI5204581253033605802ID5912Firman ihsan6009PEKANBARU61052829162070703A0163040762";

    public const KODE_TIKET_INTERVAL_DETIK = 20;

    public static function hitungCrc16Qris(string $data): string
    {
        $crc = 0xFFFF;
        for ($i = 0; $i < strlen($data); $i++) {
            $crc ^= (ord($data[$i]) << 8);
            for ($j = 0; $j < 8; $j++) {
                $crc = (($crc & 0x8000) !== 0)
                    ? (($crc << 1) ^ 0x1021) & 0xFFFF
                    : ($crc << 1) & 0xFFFF;
            }
        }
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }

    public static function qrisStatisKeDinamis(int $nominal): string
    {
        $qris = substr(self::$qrisStatisDasar, 0, -4);
        $qris = str_replace('010211', '010212', $qris);

        $nominalStr = (string) $nominal;
        $tagJumlah  = '54' . str_pad((string) strlen($nominalStr), 2, '0', STR_PAD_LEFT) . $nominalStr;

        $bagian   = explode('5802ID', $qris);
        $qrisBaru = $bagian[0] . $tagJumlah . '5802ID' . $bagian[1];
        $qrisBaru .= self::hitungCrc16Qris($qrisBaru);

        return $qrisBaru;
    }

    protected static function hitungHashFnv1a(string $str): int
    {
        $hash = 0x811c9dc5;
        for ($i = 0; $i < strlen($str); $i++) {
            $hash ^= ord($str[$i]);
            $hash = ($hash * 0x01000193) & 0xFFFFFFFF;
        }
        return $hash;
    }

    public static function buatKodeTiketRealtime(string $kodeBooking, int $waktuUnix): string
    {
        $window = intdiv($waktuUnix, self::KODE_TIKET_INTERVAL_DETIK);
        $hash   = self::hitungHashFnv1a($kodeBooking . '-' . $window);
        $kode   = strtoupper(str_pad(base_convert((string) $hash, 10, 36), 6, '0', STR_PAD_LEFT));
        return substr($kode, -6);
    }
}
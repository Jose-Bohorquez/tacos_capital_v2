<?php

final class LegacyRedirect extends Model
{
    public static function resolver(string $slugViejo): ?string
    {
        $instancia = new self();
        $stmt = $instancia->db->prepare(
            'SELECT slug_nuevo FROM legacy_slug_map WHERE slug_viejo = :slug LIMIT 1'
        );
        $stmt->execute(['slug' => $slugViejo]);
        $resultado = $stmt->fetchColumn();
        return $resultado !== false ? $resultado : null;
    }

    public function registrar(string $slugViejo, string $slugNuevo): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO legacy_slug_map (slug_viejo, slug_nuevo) VALUES (:viejo, :nuevo)
             ON DUPLICATE KEY UPDATE slug_nuevo = VALUES(slug_nuevo)'
        );
        $stmt->execute(['viejo' => $slugViejo, 'nuevo' => $slugNuevo]);
    }
}

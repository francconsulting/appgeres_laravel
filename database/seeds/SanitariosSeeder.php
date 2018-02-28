<?php

use Illuminate\Database\Seeder;

class SanitariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        self::seedSanitario();
        $this->command->info('tabla sanitario inicializada con datos');
    }

    public function seedSanitario(){
        foreach ($this->arraySanitarios as $sanitario) {
            $s = new \App\Model\Sanitario();
            $s->sDni = $sanitario['sDni'];
            $s->sNombre = $sanitario['sNombre'];
            $s->sApellidos = $sanitario['sApellidos'];
            $s->cGenero = $sanitario['cGenero'];
            $s->sEmail = $sanitario['sEmail'];
            $s->sTelefono1 = $sanitario['sTelefono1'];
            $s->sTelefono2 = $sanitario['sTelefono2'];
            $s->sDireccion = $sanitario['sDireccion'];
            $s->idA = $sanitario['idA'];
            $s->idU = $sanitario['idU'];
            $s->cActivo = $sanitario['cActivo'];
            $s->cBorrado = $sanitario['cBorrado'];
        }
    }


}

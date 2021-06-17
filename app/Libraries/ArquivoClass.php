<?php

namespace App\Libraries;

use Illuminate\Support\Facades\File;

class ArquivoClass
{
  /**
   * Fazer upload do arquivo
   *
   * @param $arquivo
   * @return array|null Caminho do arquivo
   */
  public function upload($arquivo)
  {
    $nome = $arquivo->getClientOriginalName();
    $extensao = $arquivo->getClientOriginalExtension();
    $fileName = time() . '.' . $extensao;
    $caminho = public_path("uploads/$extensao", $fileName);
    if ($arquivo->move($caminho, $fileName)) {
      return array('nome' => $nome, 'caminho' => "uploads/$extensao/$fileName");
    } else return null;
  }
  /**
   * Método utilizado para remover um arquivo dado o caminho
   *
   * @param string $caminho
   * @return void
   */
  public function remove($caminho)
  {
    if (!empty($caminho)) {
      if (File::exists(public_path($caminho))) {
        File::delete(public_path($caminho));
      }
    }
  }
}

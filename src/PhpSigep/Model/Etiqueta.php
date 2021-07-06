<?php
namespace PhpSigep\Model;

/**
 * @author: Stavarengo
 */
class Etiqueta extends AbstractModel
{

    /**
     * @var string
     */
    protected $etiquetaComDv;
    /**
     * @var string
     */
    protected $etiquetaSemDv;
    /**
     * @var int
     */
    protected $dv;

    /**
     * @return int
     */
    public function getDv()
    {
        if ($this->dv === null) {
            $numero              = mb_substr($this->getEtiquetaSemDv(), 2, 8, 'UTF-8');
            $fatoresDePonderacao = array(8, 6, 4, 2, 3, 5, 9, 7);
            $soma                = 0;
            for ($i = 0; $i < 8; $i++) {
                $soma += ($numero[$i] * $fatoresDePonderacao[$i]);
            }

            $modulo = $soma % 11;
            if ($modulo == 0) {
                $this->dv = 5;
            } else {
                if ($modulo == 1) {
                    $this->dv = 0;
                } else {
                    $this->dv = 11 - $modulo;
                }
            }
        }

        return $this->dv;
    }

    /**
     * @param int $dv
     */
    public function setDv($dv)
    {
        $this->dv = $dv;
    }

    /**
     * @return string
     */
    public function getEtiquetaSemDv()
    {
        if (!$this->etiquetaSemDv) {
            $comDv               = $this->getEtiquetaComDv();
            $this->etiquetaSemDv = mb_substr($comDv, 0, 10, 'UTF-8') . mb_substr($comDv, 11, null, 'UTF-8');
        }

        return $this->etiquetaSemDv;
    }

    /**
     * @param string $etiquetaSemDv
     */
    public function setEtiquetaSemDv($etiquetaSemDv)
    {
        $etiquetaSemDv       = str_replace(' ', '', $etiquetaSemDv);
        $this->etiquetaSemDv = $etiquetaSemDv;
    }

    /**
     * @return string
     */
    public function getEtiquetaComDv()
    {
        if (!$this->etiquetaComDv) {
            $semDv               = $this->getEtiquetaSemDv();
            $this->etiquetaComDv = mb_substr($semDv, 0, 10, 'UTF-8') . $this->getDv() . mb_substr($semDv, 10, null, 'UTF-8');
        }

        return $this->etiquetaComDv;
    }

    /**
     * @param string $etiquetaComDv
     */
    public function setEtiquetaComDv($etiquetaComDv)
    {
        $this->etiquetaComDv = $etiquetaComDv;
    }

    /**
     * @return string
     */
    public function getNumeroSemDv()
    {
        return mb_substr($this->getEtiquetaSemDv(), 2, 8, 'UTF-8');
    }

}
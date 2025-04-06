<?php

namespace Wucdbm\AudiRnseCan\Subscriber\Kodi;

use Symfony\Component\Console\Output\OutputInterface;
use Wucdbm\AudiRnseCan\CanBusFrame;
use Wucdbm\AudiRnseCan\Apps\Kodi\HTTPJSONRPCKodiControls;
use Wucdbm\AudiRnseCan\Reader\RNSESubscriber;

class KodiRNSESubscriber implements RNSESubscriber
{

    public function __construct(
        private readonly OutputInterface $output,
        private readonly HTTPJSONRPCKodiControls $controls,
        private readonly KodiRNSETVModeSubscriber $tvSubscriber,
    )
    {
    }

    public function onScrollLeft(): void
    {
        $this->controls->down();
        $this->output->writeln('KodiRNSESubscriber left');
    }

    public function onScrollRight(): void
    {
        $this->controls->up();
        $this->output->writeln('KodiRNSESubscriber right');
    }

    public function onUpShort(): void
    {
        $this->controls->left();
        $this->output->writeln('KodiRNSESubscriber up short');
    }

    public function onUpHold(int $times): void
    {
    }

    public function onUpLong(): void
    {
        $this->controls->left();
        $this->output->writeln('KodiRNSESubscriber up long');
    }

    public function onDownShort(): void
    {
        $this->controls->right();
        $this->output->writeln('KodiRNSESubscriber down short');
    }

    public function onDownHold(int $times): void
    {
    }

    public function onDownLong(): void
    {
        $this->controls->right();
        $this->output->writeln('KodiRNSESubscriber down long');
    }

    public function onWheelShort(): void
    {
        $this->controls->select();
        $this->output->writeln('KodiRNSESubscriber enter short');
    }

    public function onWheelHold(int $times): void
    {
    }

    public function onWheelLong(): void
    {
        $this->controls->select();
        $this->output->writeln('KodiRNSESubscriber enter long');
    }

    public function onReturnShort(): void
    {
        $this->controls->escape();
        $this->output->writeln('KodiRNSESubscriber escape short');
    }

    public function onReturnHold(int $times): void
    {
    }

    public function onReturnLong(): void
    {
        $this->controls->escape();
        $this->output->writeln('KodiRNSESubscriber escape long');
    }

    public function onNextShort(): void
    {
        $this->controls->next();
        $this->output->writeln('KodiRNSESubscriber next short');
    }

    public function onNextHold(int $times): void
    {
        // todo right seek
        // 				elif msg == ("37 30 01 00 20 01"): #Right
        //					windowid = xbmcgui.getCurrentWindowId()
        //					if (windowid == 12006): # MusicVisualisation.xml of VideoFullScreen.xml
        //						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":0,"value":"smallforward"},"id":1}')
        //					elif (windowid == 12005):
        //						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":1,"value":"smallforward"},"id":1}')
        //					else:
        //						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Right","id":1}')
    }

    public function onNextLong(): void
    {
        $this->controls->next();
        $this->output->writeln('KodiRNSESubscriber next long');
    }

    public function onPreviousShort(): void
    {
        $this->controls->previous();
        $this->output->writeln('KodiRNSESubscriber previous short');
    }

    public function onPreviousHold(int $times): void
    {
//        todo left seek
        // 				elif msg == ("37 30 01 00 40 01"): #Left
        //					windowid = xbmcgui.getCurrentWindowId()
        //					if (windowid == 12006): # MusicVisualisation.xml of VideoFullScreen.xml
        //						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":0,"value":"smallbackward"},"id":1}')
        //					elif (windowid == 12005):
        //						xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Player.Seek","params":{"playerid":1,"value":"smallbackward"},"id":1}')
        //					else:
        //							xbmc.executeJSONRPC('{"jsonrpc":"2.0","method":"Input.Left","id":1}')
    }

    public function onPreviousLong(): void
    {
        $this->controls->previous();
        $this->output->writeln('KodiRNSESubscriber previous long');
    }

    public function onSetupShort(): void
    {
        $this->controls->playPause();
        $this->output->writeln('KodiRNSESubscriber setup short');
    }

    public function onSetupHold(int $times): void
    {
    }

    public function onSetupLong(): void
    {
        $this->controls->playPause();
        $this->output->writeln('KodiRNSESubscriber setup long');
    }

    public function isTvMode(): bool
    {
        return $this->tvSubscriber->isTvModeActive();
    }

}

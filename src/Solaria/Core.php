<?php

namespace Solaria;

use muqsit\invmenu\InvMenuHandler;
use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\item\ItemFactory;
use pocketmine\network\Network;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use Solaria\API\RankAPI;
use Solaria\API\KothAPI;
use Solaria\Command\Admin\AddPbCommand;
use Solaria\Command\Admin\ForceKothCommand;
use Solaria\Command\Admin\AddRankCommand;
use Solaria\Command\Admin\BroadcastCommand;
use Solaria\Command\Admin\CastCommand;
use Solaria\Command\Admin\TopKillCommand;
use Solaria\Command\Admin\TopDeathCommand;
use Solaria\Command\Admin\ListpermissionCommande;
use Solaria\Command\Grade\MineMvpCommand;
use Solaria\Command\Grade\MineVipCommand;
use Solaria\Command\Joueur\LarguageCommand;
use Solaria\Command\Joueur\MineInfoCommand;
use Solaria\Command\Joueur\MyPbCommand;
use Solaria\Command\Admin\NPCCommand;
use Solaria\Command\Admin\NPCHuman;
use Solaria\Command\Grade\ParticleCommand;
use Solaria\Command\Admin\RankCommand;
use Solaria\Command\Admin\RedemCommand;
use Solaria\Command\Admin\RemovePermissionCommand;
use Solaria\Command\Admin\RemoveRankCommand;
use Solaria\Command\Joueur\PurifCommand;
use Solaria\Command\Joueur\SendPbCommand;
use Solaria\Command\Admin\SetFormatCommand;
use Solaria\Command\Admin\SetNametagCommand;
use Solaria\Command\Admin\SetPbCommand;
use Solaria\Command\Admin\SetpermissionCommand;
use Solaria\Command\Admin\SetRankCommand;
use Solaria\Command\Admin\SetupermissionCommand;
use Solaria\Command\Grade\EnderChestCommand;
use Solaria\Command\Joueur\AtmCommand;
use Solaria\Command\Joueur\BoutiqueCommand;
use Solaria\Command\Joueur\FeedCommand;
use Solaria\Command\Joueur\ListCommand;
use Solaria\Command\Admin\DeopCommand;
use Solaria\Command\Admin\MaintenanceCommand;
use Solaria\Command\Admin\OpCommand;
use Solaria\Command\Joueur\KitCommand;
use Solaria\Command\Joueur\NvCommand;
use Solaria\Command\Joueur\ReportCommand;
use Solaria\Command\Joueur\SpawnCommand;
use Solaria\Command\Joueur\EventCommand;
use Solaria\Command\Joueur\TpAcceptCommand;
use Solaria\Command\Joueur\TpaCommand;
use Solaria\Command\Joueur\TpaHereCommand;
use Solaria\Command\Joueur\CosmeticCommand;
use Solaria\Command\Joueur\TrashCommand;
use Solaria\Command\Joueur\MinageCommand;
use Solaria\Command\Staff\BanCommand;
use Solaria\Command\Staff\ClearCommand;
use Solaria\Command\Staff\FreezeCommand;
use Solaria\Command\Staff\KickCommand;
use Solaria\Command\Staff\MuteChatCommand;
use Solaria\Command\Staff\MuteCommand;
use Solaria\Command\Staff\StaffModeCommand;
use Solaria\Command\Staff\TBanCommand;
use Solaria\Command\Staff\UnBanCommand;
use Solaria\Command\Staff\UnMuteCommand;
use Solaria\Item\Armure\TopazeBoots;
use Solaria\Item\Armure\TopazeChestplate;
use Solaria\Item\Armure\TopazeHelmet;
use Solaria\Item\Armure\TopazeLeggins;
use Solaria\Listener\EnderChestListener;
use Solaria\Listener\MaintenanceListener;
use Solaria\Listener\MsgReponseAutoListener;
use Solaria\Listener\PearlCooldownListener;
use Solaria\Listener\SpawnListener;
use Solaria\Listener\PotionListener;
use Solaria\Listener\Events\KothEvents;
use Solaria\Listener\StaffModeListener;
use Solaria\Protection\Protection;
use Solaria\Tasks\AtmTask;
use Solaria\Tasks\LarguageTask;
use Solaria\Tasks\MinageTask;
use Solaria\Tasks\MsgAutoTask;
use Solaria\Tasks\KothTask;
use Solaria\Tasks\TpTask;
use Solaria\Listener\PlayerDeath;
use Solaria\Utils\Utils;
use Solaria\Command\Joueur\MsgCommand;
use Solaria\Entity\TopKillEntity;
use Solaria\Entity\TopDeathEntity;
use Solaria\Listener\JoinListener;

class Core extends PluginBase implements Listener {
    private static $core;
    public static $rank;
    public static $kothev;

    public static $tpahere = [];
    public static $tpa = [];

    public function onEnable() {
        self::$core = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new MaintenanceListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Protection(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new EnderChestListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PotionListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new StaffModeListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PearlCooldownListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new KothEvents($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new PlayerDeath($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new SpawnListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new JoinListener(), $this);
        $this->getLogger()->info("--------------------------------------------");
        $this->getLogger()->info("Solaria - KitMap enable !");
        $this->getLogger()->info("--------------------------------------------");

        //$this->getScheduler()->scheduleRepeatingTask(new LarguageTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new MinageTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new MsgAutoTask(), 20);
        $this->getScheduler()->scheduleRepeatingTask(new AtmTask(), 3000);

        if (!InvMenuHandler::isRegistered()) InvMenuHandler::register($this);


        $this->getServer()->loadLevel("kitmap");
        $this->getServer()->loadLevel("Minage");

        $this->initEntity();
        $this->initCommands();


        //Config
        @mkdir($this->getDataFolder() . "Player");
        @mkdir($this->getDataFolder() . "Ranks");
        @mkdir($this->getDataFolder() . "Jetons");
        @mkdir($this->getDataFolder() . "Events");
        @mkdir($this->getDataFolder() . "Top");
        $this->saveResource("Config.yml");
        $this->cfg = new Config($this->getDataFolder() . "Config.yml", Config::YAML);

        $this->getServer()->getCommandMap()->registerAll("Solaria KitMap", [

           new MaintenanceCommand(),
           new KickCommand(),
           new OpCommand(),
           new DeopCommand(),
           new SpawnCommand(),
           //new KitCommand(),
           new ListCommand(),
           new BoutiqueCommand($this),
           new NPCCommand(),
           new FeedCommand(),
           new ReportCommand(),
           new EnderChestCommand(),
           new AddRankCommand(),
           new SetRankCommand(),
           new SetNametagCommand(),
           new SetpermissionCommand(),
           new ListpermissionCommande(),
           new RankCommand(),
           new RemoveRankCommand(),
           new RemovePermissionCommand(),
           new SetupermissionCommand(),
           new SetFormatCommand(),
           new ClearCommand(),
           new MuteChatCommand(),
           new TrashCommand(),
           new RedemCommand(),
           new BanCommand(),
            new MuteCommand(),
            new UnMuteCommand(),
            new UnBanCommand(),
            new TBanCommand(),
            new FreezeCommand(),
            new BroadcastCommand(),
            new ParticleCommand(),
            new NvCommand(),
            new AtmCommand(),
            new MyPbCommand(),
            new SetPbCommand(),
            new AddPbCommand(),
            new SendPbCommand(),
            new MsgCommand(),
            new StaffModeCommand(),
            new MineVipCommand(),
            new MineMvpCommand(),
            new PurifCommand(),
            //new LarguageCommand(),
            new CastCommand(),
            new MineInfoCommand(),
            new EventCommand($this),
            new ForceKothCommand($this),
            new CosmeticCommand($this),
            new MinageCommand(),
            new TopKillCommand(),
            new TopDeathCommand()

        ]);


        //Utils::sendWebHook("・Le serveur viens de s'allumé.", "**SERVEUR**");



        $this->getServer()->getNetwork()->setName("§1» §9Solaria §fKitMap §1«§f");

        self::$rank = new RankAPI($this);
        self::$kothev = new KothAPI($this);
        $this->getKothAPI()->set("koth_nexTime", 0);
        $this->getScheduler()->scheduleRepeatingTask(new KothTask($this), 20);
        CosmeticCommand::$atoutPlayers = [];

        BanCommand::$banlist = new Config(Core::getInstance()->getDataFolder() . "banlist.yml", Config::YAML);
        MuteCommand::$mutelist = new Config(Core::getInstance()->getDataFolder() . "mutelist.yml", Config::YAML);
        FreezeCommand::$freeze = new Config(Core::getInstance()->getDataFolder() . "freeze.yml", Config::YAML);
        Utils::$walk = new Config(Core::getInstance()->getDataFolder() . "walk.yml", Config::YAML);
        AtmCommand::$atm = new Config(Core::getInstance()->getDataFolder() . "atm.yml", Config::YAML);
        BoutiqueCommand::$pb = new Config($this->getDataFolder() . "boutique.yml", Config::YAML);
        
        Utils::sendWebHook("Le serveur c'est allumé avec **succès**", "**START**", "https://discord.com/api/webhooks/926018950683328562/S5p1qSZnv23ezD1LR9bgOD2Chy_eDkY3y_ctG-kgpuDdTGzDE9E2TtTV8fkGqEkd2KuM");
    }
    
    public function onDisable(){
      $this->getKothAPI()->stop();
    }

    public static function getInstance(): Core
    {

        return self::$core;

    }

    private function initCommands() : void
    {
        $cmds = ["op", "list", "deop", "particles", "whitelist", "checkperm", "tell", "msg", "w", "deban", "pardon", "unban", "defaultgamemode", "ban", "kick", "save-all", "difficulty", "genplugin", "help", "?", "me", "title", "save-off", "seed", "particle", "about", "/cyl", "/blockinfo", "/sphere", "/pyramid", "/outline", "/naturalize", "/stack", "save-on", "/tree", "/rotate", "/hcyl", "/hcube", "/hsphere", "/hpyramid", "/commands", "/clearinventory", "/cube", "/merge", "/fix", "/move", "/schematic", "buildertools", "about", "kill", "banlist", "dumpmemory", "extractplugin","gc", "mixer", "makeserver", "tell", "mp", "msg", "w"];
        $commands = $this->getServer()->getCommandMap();

        foreach ($cmds as $cmd) {
            $command = $commands->getCommand($cmd);
            if ($command !== null) {
                $command->setLabel("old_" . $cmd);
                $commands->unregister($command);
            }
        }
    }
    private function registerEntity($entity): void{

        Entity::registerEntity($entity, true);

    }

    public function initEntity(): void {

        $entities = [NPCHuman::class, TopKillEntity::class, TopDeathEntity::class];

        foreach ($entities as $entitie) {

            $this->registerEntity($entitie);

        }

    }
    public static function getRankAPI(): RankAPI {

        return self::$rank;

    }

    public function getKothAPI(): KothAPI {
      return self::$kothev;
    }
    
    public static function getTopKill(){
        $cfg = new Config(self::getInstance()->getDataFolder() . "Top/TopKill.yml", Config::YAML);
        return $cfg->getAll();
    }
    
    public static function getTopDeath(){
        $cfg = new Config(self::getInstance()->getDataFolder() . "Top/TopDeath.yml", Config::YAML);
        return $cfg->getAll();
    }

    private function registerItem($item, $truefalse) : void {
        ItemFactory::registerItem($item, $truefalse);
    }
}
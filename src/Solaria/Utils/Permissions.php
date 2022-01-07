<?php

namespace Solaria\Utils;

interface Permissions {

    public const MAINTENANCE_ADMIN = "admin";
    public const MAINTENANCE_BYPASS = "guide";
    public const KICK = "guide";
    public const OP = "admin";
    public const NPC = "admin";
    public const KIT_VIP = "kit.vip";
    public const KIT_VIPPLUS = "kit.vipplus";
    public const KIT_HERO = "kit.hero";
    public const KIT_CHAMPION = "kit.champion";
    public const KIT_HEAL = "kit.heal";
    public const PROTECTION_BYPASS = "admin.protection";
    public const ENDERCHEST = "grade";
    public const ENDERCHEST_VIP = "grade.enderchest.vip";
    public const ENDERCHEST_CHAMPION = "grade.enderchest.champion";
    public const ADDRANK = "admin";
    public const SETRANK = "admin";
    public const SETNAMETAG = "admin";
    public const SETPERM = "admin";
    public const LISTPERM = "admin";
    public const RANKS = "admin";
    public const RMRANK = "admin";
    public const RMPERM = "admin";
    public const SETUPERM = "admin";
    public const SETFORMAT = "admin";
    public const CLEAR = "modo";
    public const MUTECHAT = "modo";
    public const ENDERCHEST_INTERACT = "joueur.enderchest";
    public const REDEM = "admin";
    public const VANISH = " modo";
    public const STAFFMODE = "guide";
    public const MUTE = "guide";
    public const BAN = "modo";
    public const FREEZE = "modo";
    public const BROADCAST = "admin";
    public const GIVEPB = "admin";
    public const SEEMSG = "modo";
    public const MINEVIP = "vip";
    public const MINEMVP = "mvp";
    public const PURIFVIP = "vip";
    public const PURIFMVP = "mvp";
    public const PURIFSUPREME = "supreme";
    public const LARGUAGEFORCE = "admin";

    public const P_REDSTONE = "particle.redstone";
    public const P_LAVA = "particle.lava";
    public const P_FIRE = "particle.fire";
    public const P_WATER = "particle.water";
}
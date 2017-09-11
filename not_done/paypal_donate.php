<?php
define('INWEB', True);
require_once("include/config.php");
//пароль
head("Donate");
if($_GET['a']=="auglist")
{
    ?>
    <p><strong>AUGUMENTS LIST </strong></p>

<p>1-Item Skill: Aggression Chance: Provokes a target to attack during an ordinary physical attack. Power 659. <br />
  2-Item Skill: Charm	Chance: Decreases a target's urge to attack during a general physical attack. Power 330. <br />
  3-Item Skill: Mana Burn	Chance: Burns up a target's MP during an ordinary physical attack. Power 88. <br />
  4-Item Skill: Slow	Chance: Momentarily decreases a target's speed during an ordinary physical attack. Effect 3. <br />
  5-Item Skill: Winter	Chance: Momentarily decreases a target's Atk. Spd. during an ordinary physical attack. Effect 3. <br />
  6-Item Skill: Stun	Chance: Momentarily throws the target into a state of shock during an ordinary physical attack. <br />

  7-Item Skill: Hold	Chance: Momentarily throws the target into a state of hold during an ordinary physical attack. The target cannot be affected by any additional hold attacks while the effect lasts. <br />
  8-Item Skill: Sleep	Active: Momentarily throws the target into a state of sleep during a general physical attack. Additional chance to be put into sleep greatly decreases while the effect lasts. <br />
  9-Item Skill: Paralyze	Chance: Momentarily throws the target into a state of paralysis during an ordinary physical attack. <br />
  10-Item Skill: Medusa	Chance: Momentarily throws the target into a petrified state during a general physical attack. <br />
  11-Item Skill: Fear	Chance: Momentarily throws the target into a state of fear and causes him to flee during a general physical attack. <br />
  12-Item Skill: Poison	Chance: Momentarily throws the target into a poisoned state during a general physical attack. Effect 8. <br />

  13-Item Skill: Bleed	Chance: Momentarily throws the target into a bleeding state during a general physical attack. Effect 8. <br />
  14-Item Skill: Silence	Chance: Momentarily blocks the target's magic skill during a general physical attack. <br />
  15-Item Skill: Doom	Chance: Momentarily blocks all of the target's physical and magic skills during a general physical attack. <br />
  16-Item Skill: Mana Burn Chance: Burns up a target's MP during magic use. Power 88. <br />
  17-Item Skill: Slow	Chance: Momentarily decreases the target's speed during magic use. Effect 3. <br />
  18-Item Skill: Winter	Chance: Momentarily decreases the target's Atk. Spd. during magic use. Effect 3. <br />

  19-Item Skill: Stun	Chance: Momentarily throws the target into a state of shock during magic use. <br />
  20-Item Skill: Hold	Chance: Momentarily throws the target into a state of hold during magic use. The target cannot be affected by any additional hold attacks while the effect lasts. <br />
  21-Item Skill: Sleep	Active: Momentarily throws the target into a state of sleep during magic use. Additional chance to be put into sleep greatly decreases while the effect lasts. <br />
  22-Item Skill: Paralyze	Chance: Momentarily throws the target into a state of paralysis during magic use. <br />
  23-Item Skill: Medusa	Chance: Momentarily throws the target into a petrified state during magic use. <br />
  24-Item Skill: Fear	Chance: Momentarily throws the target into a state of fear and causes him to flee during magic use. <br />

  25-Item Skill: Poison	Chance: Momentarily throws the target into a poisoned state during magic use. Effect 8. <br />
  26-Item Skill: Bleed	Chance: Momentarily throws the target into a bleeding state during magic use. Effect 8. <br />
  27-Item Skill: Silence	Chance: Momentarily blocks the target's magic skill during magic use. <br />
  28-Item Skill: Doom	Chance: Momentarily blocks all of the target's physical and magic skills during magic use. <br />
  29-Item Skill: Aggression Up Chance: Increases a target's urge to attack during a critical attack. Power 659. <br />
  30-Item Skill: Aggression Down Chance: Decreases a target's urge to attack during a critical attack. Power 330. <br />

  31-Item Skill: Mana Burn Chance: Burns up a target's MP during a critical attack. Power 88. <br />
  32-Item Skill: Slow	Chance: Momentarily decreases the target's speed during a critical attack. Effect 3. <br />
  33-Item Skill: Winter	Chance: Momentarily decreases the target's Atk. Spd. during a critical attack. Effect 3. <br />
  34-Item Skill: Stun	Chance: Momentarily throws the target into a state of shock during a critical attack. <br />
  35-Item Skill: Hold	Chance: Momentarily throws the target into a state of hold during a critical attack. The target cannot be affected by any additional hold attacks while the effect lasts. <br />
  36-Item Skill: Sleep	Active: Momentarily throws the target into a state of sleep during a critical attack. Additional chance to be put into sleep greatly decreases while the effect lasts. <br />

  37-Item Skill: Paralyze	Chance: Momentarily throws the target into a state of paralysis during a critical attack. <br />
  38-Item Skill: Medusa	Chance: Momentarily throws the target into a petrified state during a critical attack. <br />
  39-Item Skill: Fear	Chance: Momentarily throws the target into a state of fear and causes him to flee during a critical attack. <br />
  40-Item Skill: Poison	Chance: Momentarily throws the target into a poisoned state during a critical attack. Effect 8. <br />
  41-Item Skill: Bleed	Chance: Momentarily throws the target into a bleeding state during a critical attack. Effect 8. <br />
  42-Item Skill: Silence	Chance: Momentarily blocks the target's magic skill during a critical attack. <br />

  43-Item Skill: Doom	Chance: Momentarily blocks all of the target's physical and magic skills during a critical attack. <br />
  44-Item Skill: Heal	Active: Immediately recovers your HP. Power 552. <br />
  45-Item Skill: Blessed Body Active: Increases the Max. HP by 300 temporarily. <br />
  46-Item Skill: Battle Roar Active: Increases the Max. HP temporarily and restores HP by the increased amount. <br />
  47-Item Skill: Prayer	Active: Increases the effectiveness of HP recovery magic temporarily. <br />
  48-Item Skill: Recharge	Active: Regenerates MP. Power 69. <br />

  49-Item Skill: Blessed Soul Active: Increases the maximum MP by 200 temporarily. <br />
  50-Item Skill: Mana Gain Active: Increases the recharge recover rate of MP. <br />
  51-Item Skill: Ritual	Active: Regenerates CP. Power 473. <br />
  52-Item Skill: Cheer	Active: Increases the Max. CP by 300 temporarily. <br />
  53-Item Skill: Might	Active: Increases P. Atk. temporarily. <br />
  54-Item Skill: Empower	Active: Increases M. Atk. temporarily. <br />

  55-Item Skill: Duel Might Active: Increases PVP P. Atk. temporarily. <br />
  56-Item Skill: Shield	Active: Increases P. Def. temporarily. <br />
  57-Item Skill: Magic Barrier Active: Increases M. Def. temporarily.<br />
  58-Item Skill: Duel Weakness Active: Decreases the opponent's PVP P. Atk. temporarily.<br />
  59-Item Skill: Heal Empower Active: Increases the power of HP recovery magic temporarily. <br />
  60-Item Skill: Agility	Active: Increases Dodge temporarily. <br />

  61-Item Skill: Guidance	Active: Increases Accuracy temporarily. <br />
  62-Item Skill: Focus	Active: Increases the chance of a critical attack temporarily. <br />
  63-Item Skill: Wild Magic Active: Increases the critical attack rate of magic attacks temporarily. <br />
  64-Item Skill: Kiss of Eva Active: Increases Lung Capacity temporarily. <br />
  65-Item Skill: Acrobatics Active: Increases the height from which you can jump without sustaining damage temporarily.<br />
  66-Item Skill: Iron Body Active: Raises resistance to damage from falling. <br />

  67-Item Skill: Vampiric Rage Active: Increases the ability to restore some HP from the damage inflicted on an enemy temporarily. Excludes damage by skill or long-range attacks. <br />
  68-Item Skill: Aggression Active: Increases the target's urge to attack. Power 659. <br />
  69-Item Skill: Charm Active: Decreases a target's urge to attack. Power 330. <br />
  70-Item Skill: Peace Active: Puts the opponent's mind at peace and erases the desire to attack. <br />
  71-Item Skill: Trick Active: Cancels the target's status. <br />
  72-Item Skill: Vampiric Touch Active: Absorbs HP. Power 88. <br />

  73-Item Skill: Mana Burn Active: Burns up the enemy's MP. Power 120. <br />
  74-Item Skill: Unlock Active: Opens level 3 doors with 100% probability and chests below level 72 with 90% probability. Requires 17 Keys of a Thief. <br />
  75-Item Skill: Firework	Active: Ignites a Firework. <br />
  76-Item Skill: Large Firework Active: Ignites a Large Firework. <br />
  77-Item Skill: Lesser Celestial Shield Active: Bestows temporary invincibility. <br />
  78-Item Skill: Stealth	Active: Temporarily blocks a monster's pre-emptive attack. Fighting ability significantly decreases while in effect. <br />

  79-Item Skill: Resurrection Active: Resurrects a corpse. Restores about 70% of additional Exp. <br />
  80-Item Skill: Skill Clarity Active: Temporarily decreases the MP consumption rate for physical skills. <br />
  81-Item Skill: Spell Clarity Active: Temporarily decreases the MP consumption rate for magical skills. <br />
  82-Item Skill: Music Clarity Active: Temporarily decreases the MP consumption rate for song/dance skills. <br />
  83-Item Skill: Clarity	Active: Temporarily decreases the MP consumption rates for all skills. <br />
  84-Item Skill: Prominence Active: Detonates a fireball by compressing the air around the caster. Power 110.<br />

  85-Item Skill: Hydro Blast Active: Unleashes a spray of highly pressurized water. Power 110. <br />
  86-Item Skill: Hurricane Active: Creates a whirlwind of destruction. Power 110. <br />
  87-Item Skill: Stone	Active: Attacks the target with a stone boulder. Power 110. <br />
  88-Item Skill: Solar Flare Active: Unleashes a sacred attack. Power 110. <br />
  89-Item Skill: Shadow Flare Active: Unleashes a dark attack. Power 110. <br />
  90-Item Skill: Aura Flare Active: Unleashes an elemental attack. Power 110. <br />

  91-Item Skill: Prominence Active: Unleashes a flaming attack against the enemies near a target. Power 55. <br />
  92-Item Skill: Hydro Blast Active: Unleashes a powerful liquidy attack against the enemies near a target. Power 55. <br />
  93-Item Skill: Hurricane Active: Unleashes a powerful gusting attack against the enemies near a target. Power 55. <br />
  94-Item Skill: Stone	Active: Attacks the enemies near a target with a stone boulder. Power 55. <br />
  95-Item Skill: Solar Flare Active: Unleashes a sacred attack against the enemies near a target. Power 55. <br />
  96-Item Skill: Shadow Flare Active: Unleashes a dark attack against the enemies near a target. Power 55. <br />

  97-Item Skill: Aura Flare Active: Unleashes an elemental attack against the enemies near a target. Power 55. <br />
  98-Item Skill: Prominence Active: Unleashes a flaming attack against nearby enemies. Power 55. <br />
  99-Item Skill: Hydro Blast Active: Unleashes a powerful liquidy attack against nearby enemies. Power 55. <br />
  100-Item Skill: Hurricane Active: Unleashes a powerful gusting attack against nearby enemies. Power 55. <br />
  101-Item Skill: Stone	Active: Unleashes an earthen attack against nearby enemies. Power 55. <br />
  102-Item Skill: Solar Flare Active: Unleashes a sacred attack against nearby enemies. Power 55. <br />

  103-Item Skill: Shadow Flare Active: Unleashes a dark attack against nearby enemies. Power 55. <br />
  104-Item Skill: Aura Flare Active: Unleashes an elemental attack against nearby enemies. Power 55. <br />
  105-Item Skill: Slow	Active: Temporarily decreases a target's speed. <br />
  106-Item Skill: Winter	Active: Temporarily decreases a target's Atk. Spd. <br />
  107-Item Skill: Stun	Active: Temporarily throws the target into a state of shock. <br />
  108-Item Skill: Hold	Active: Temporarily throws the target into a state of hold. The target cannot be affected by any additional hold attacks while the effect lasts. <br />

  109-Item Skill: Sleep	Skills Used: Instantly puts a target into sleep. Additional chance to be put into sleep greatly decreases while the effect lasts. <br />
  110-Item Skill: Paralyze Active: Temporarily throws the target into a state of paralysis. <br />
  111-Item Skill: Medusa	Active: Temporarily throws the target into a petrified state. <br />
  112-Item Skill: Fear	Active: Momentarily throws the target into a state of fear and causes him to flee. <br />
  113-Item Skill: Poison	Active: Temporarily poisons a target. Effect 8. <br />
  114-Item Skill: Bleed	Active: Temporarily causes a target to bleed heavily. Effect 8. <br />

  115-Item Skill: Silence	Active: Temporarily blocks the target's magic skills. <br />
  116-Item Skill: Doom Active: Temporarily blocks all of the target's physical/magic skills. <br />
  117-Item Skill: Skill Refresh Active: Temporarily decreases the re-use time for physical skills. <br />
  118-Item Skill: Spell Refresh Active: Temporarily decreases the re-use time for magic skills. <br />
  119-Item Skill: Music Refresh Active: Temporarily decreases the re-use time for song/dance skills. <br />
  120-Item Skill: Refresh	Active: Temporarily decreases the re-use times for all skills. <br />

  121-Item Skill: Mystery Skill Active: Increases your head size. <br />
  122-Item Skill: Reflect Damage Active: Allows you to reflect some of the damage you incurred back to the enemy for a certain amount of time. Excludes damage from skill or remote attacks. <br />
  123-Item Skill: Party Recall Active: Teleports party members to a village. Cannot be used in a specially designated place such as the GM Consultation Service. <br />
  124-Item Skill: Music	Active: Plays music. <br />
  125-Item Skill: Heal	Chance: Restores your HP by using attack rate. <br />
  126-Item Skill: Blessed Body Chance: Increases Max. HP by using attack rate for a certain amount of time. <br />

  127-Item Skill: Prayer	Chance: Increases the effect of HP recovery magic by using attack rate for a certain amount of time. <br />
  128-Item Skill: Recharge Chance: Restores your MP by using attack rate. <br />
  129-Item Skill: Blessed Soul Chance: Increases maximum MP when under attack for a certain amount of time. <br />
  130-Item Skill: Mana Gain Chance: Increases the recharge recovery rate of MP when under attack. <br />
  131-Item Skill: Ritual	Chance: Restores CP when under attack. <br />
  132-Item Skill: Cheer	Chance: Increases Max. CP when under attack for a certain amount of time. <br />

  133-Item Skill: Might	Chance: Temporarily increases P. Atk. when under attack. <br />
  134-Item Skill: Empower	Chance: Temporarily increases PVP M. Atk. when under attack. <br />
  135-Item Skill: Duel Might Chance: Temporarily increases PVP P. Atk. when under attack. <br />
  136-Item Skill: Shield	Chance: Temporarily increases P. Def. when under attack. <br />
  137-Item Skill: Magic Barrier Chance: Temporarily increases M. Def. when under attack. <br />
  138-Item Skill: Duel Weakness Chance: Temporarily decreases the opponent's PVP P. Atk. when you are under attack. <br />

  139-Item Skill: Agility	Chance: Temporarily increases Evasion when under attack. <br />
  140-Item Skill: Guidance Chance: Temporarily increases Accuracy when under attack. <br />
  141-Item Skill: Focus	Chance: Temporarily increases the critical attack rate when under attack. <br />
  142-Item Skill: Wild Magic Chance: Temporarilty increases the critical attack rate of magic attacks when under attack. <br />
  143-Item Skill: Charm	Chance: Decreases the enemy's urge to attack when you are under attack. <br />
  144-Item Skill: Slow	Chance: Momentarily decreases a target's Speed when you are under attack. <br />

  145-Item Skill: Winter	Chance: Momentarily decreases a target's Atk. Spd. when you are under attack. <br />
  146-Item Skill: Stun	Chance: Momentarily stuns the target when you are under attack. <br />
  147-Item Skill: Hold	Active: Momentarily holds the target when you are under attack. Additional chance to be put into hold greatly decreases while the effect lasts. <br />
  148-Item Skill: Sleep	Active: Momentarily causes the target to sleep when you are under attack. Additional chance to be put into sleep greatly decreases while the effect lasts. <br />
  149-Item Skill: Paralyze Chance: Momentarily paralyzes the target when you are under attack. <br />
  150-Item Skill: Medusa	Chance: Momentarily petrifies the target when you are under attack. <br />

  151-Item Skill: Fear	Chance: Momentarily instills a feeling of fear on the target that causes it to flee when you are under attack. <br />
  152-Item Skill: Poison	Chance: Momentarily poisons the target when you are under attack. Effect 8. <br />
  153-Item Skill: Bleed	Chance: Momentarily causes the target to bleed when you are under attack. Effect 8. <br />
  154-Item Skill: Silence	Chance: Momentarily blocks the target's magic skills when you are under attack. <br />
  155-Item Skill: Doom	Chance: Momentarily blocks all of the target's physical and magic skills when you are under attack. <br />
  156-Item Skill: Prayer	Passive: Increases the effect of HP recovery magic when equipped. <br />

  157-Item Skill: Mana Gain Passive: Increases the recharge recovery rate of MP when equipped. <br />
  158-Item Skill: Might	Passive: Increases P. Atk. when equipped. <br />
  159-Item Skill: Empower	Passive: Increases M. Atk. when equipped.<br />
  160-Item Skill: Duel Might Passive: Increases PVP P. Atk. when equipped. <br />
  161-Item Skill: Shield	Passive: Increases P. Def. when equipped. <br />
  162-Item Skill: Magic Barrier Passive: Increases M. Def. when equipped. <br />

  163-Item Skill: Heal Empower Passive: Increases the power of HP recovery magic when equipped. <br />
  164-Item Skill: Agility	Passive: Increases evasion when equipped. <br />
  165-Item Skill: Guidance Passive: Increases accuracy when equipped. <br />
  166-Item Skill: Focus	Passive: Increases critical attack rate when equipped. <br />
  167-Item Skill: Wild Magic Passive: Increases the critical attack rate of magic attacks when equipped. <br />
  168-Item Skill: Weight Limit Passive: Increases the weapon weight limit by 2 times when equipped. <br />

  169-Item Skill: Kiss of Eva Passive: Increases lung capacity when equipped. <br />
  170-Item Skill: Acrobatics Passive: Increases the height from which you can jump without sustaining damage when equipped. <br />
  171-Item Skill: Iron Body Passive: Raises resistance to damage from falling when equipped. <br />
  172-Item Skill: Skill Clarity Passive: Decreases the MP consumption rate for physical skills when equipped. <br />
  173-Item Skill: Spell Clarity Passive: Decreases the MP consumption rate for magic skills when equipped. <br />
  174-Item Skill: Music Clarity Passive: Decreases the MP consumption rate for song/dance skills when equipped. <br />

  175-Item Skill: Clarity Passive: Decreases the MP consumption rate for all skills when equipped. <br />
  176-Item Skill: Reflect Damage Passive: Increases the ability to reflect some of the damage you incur back to the enemy when equipped. Excludes damage by skill or long-range attacks.</p>
<p><a href="paypal_donate.php" target="_self">BACK TO DONATIONS</a></p>

    <?php
}
else
{
?>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick" />
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
" />
<input type="image" src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online." />
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
</form>
<div>
<p align="center">DONATIONS</p>

<p align="center">
<p class="style10">AGREEMENT:</p>

<p>Submission of a donation to, FANTASY WORLD using the paypal.com system is a voluntary action completely unnecessary for game play on this server.</p>
<p>By submitting any type of monetary unit to FANTASY WORLD, you agree that you are not entitled to receive anything from FANTASY WORLD.</p>
<p>This form of donation is completely voluntary, and is for the better of the server.</p>
<p>Rewards are given to those who have donated as a thanks to you for your continued support of the server.</p>
<p>By submitting a donation via paypal to FANTASY WORLD you agree to the terms presented in the following 6, lettered statements (A-F), and their subsections:</p>
<p>A. Donation will not be refunded.</p>
<p>B. You will not dispute the charges incurred to your paypal account from your voluntary donation.</p>
<p>C. You realize that this is a voluntary donation, and in being a donation it is not refundable.</p>
<p>D. You understand the concept of a &quot;donation&quot; and &quot;voluntary&quot;, and agree to all the aforementioned rules (see subsections a and b).</p>
<p>Donation [doh-ney-shuhn] - Noun - an act or instance of presenting something   as a gift, grant, or contribution.</p>
<p>Voluntary [vol-uhn-ter-ee] - Adjective - done, made, brought about,   undertaken, etc., of one's own accord or by free choice.</p>
<p>E. If you do not agree to these terms, or cannot honor this contract, do not   send in a donation.</p>
<p>F. Lost rewards will not be replaced. </p>
<p>In order to donate just click on the paypal button located in the center of   the screen.</p>
<p><strong>All major forms of payment will be accepted.</strong></p>
<p>&nbsp;</p>
<p><strong>INSTRUCTIONS:</strong></p>
<p>&nbsp;</p>
<p>A. After donating please send an email to <a href="mailto:antons007@gmail.com">antons007@gmail.com</a> ( antons007@gmail.com ) with your transaction number.</p>
<p>You must send us from the email adress u got in the paypal account! </p>
<p>B. Please send us the ammount of donation.</p>
<p>C. Please send us the desired reward from the server. </p>
<p>D. Rewards will be given directly in the game by an admin, so please send us your account and character name informations.</p>
<p>E. Inform us when you will be in the game to receive the reward.</p>
<p>&nbsp;</p>
<p><strong>REWARD LIST:</strong></p>
<p>==========================================================</p>
<p><strong>1 full char lvl 85 ( 1 first class + 6 subclasses ) = 10 euro</strong></p>

<p>==========================================================</p>
<p><strong>1 x Necklace of Valakas [ increased: Hp, Patk, Matk, Crit, Etc ]   +30 = 21 euro</strong></p>
<p><strong>1 x Freya Necklace </strong> <strong>+30</strong> <strong>= 16 euro</strong></p>
<p><strong>1 x Blessed Freya Necklace </strong> <strong>+30</strong> <strong>= 16 euro</strong></p>

<p><strong>1 x Earring of Antharas</strong> <strong>+30</strong> <strong>= 16 euro</strong></p>
<p><strong>1 x Ring of Baium</strong> <strong>+30</strong> <strong>= 16 euro</strong></p>
<p><strong>1 x Zaken's Earring +30</strong> <strong>= 16 euro</strong></p>
<p><strong>1 x Ring of Queen Ant</strong> <strong>+30</strong> <strong>= 16 euro</strong></p>

<p><strong>1 x Frintezza's Necklace </strong> <strong>+30</strong> <strong>= 16 euro</strong></p>
<p><strong>1 x Earring of Orfen</strong> <strong>+30</strong> <strong>= 10 euro</strong></p>
<p><strong>1 x Beleth's Ring </strong> <strong>+30</strong> <strong>= 10 euro</strong></p>

<p><strong>1 x Baylor's Earring </strong> <strong>+30</strong> <strong>= 5 euro</strong></p>

<p>==========================================================</p>
<p><strong>1 x Armor FULL set + shield/sigil ( any set from shop PVP and SA ) +30   = 20 euro</strong></p>
<p><strong>3 x  Any other armor ( Cloak + Shirt + Belt ) +30   = 10 euro</strong></p>
<p><strong>1 x  Any tattoo's from shop +30   = 10 euro</strong></p>

<p><strong>1 x Full atribute (3 atribute x each armor part) lvl 7 = 25 euro </strong></p>

<p>==========================================================</p>
<p><strong>1 x Weapon ( any weapon from shop including PVP  and SA ) +25 = 16 euro</strong></p>
<p><strong>1 x Weapon atribute Level 7 = 10 euro </strong></p>
<p><strong>1 x Augument for Weapon  = 15 euro </strong><a href="paypal_donate.php?a=auglist" target="_self">( Press here for the auguments list )</a></p>

<p>==========================================================</p>
<p><strong>40 x Giant's Codex - Mastery ( enchant skills safe ) = 10 euro</strong></p>

<p><strong>1 x Skill Full Enchanted = 25 euro </strong></p>
<p><strong>1 x Skill routte change = 5 euro </strong></p>

<p>==========================================================</p>
<p><strong>255 Recomands = 5 euro</strong></p>

<p>==========================================================</p>
<p><strong>Name / sex change = 3 euro</strong></p>

<p>==========================================================</p>
<p><strong>Any pet lvl 85 = 5 euro</strong></p>

<p>==========================================================</p>
<p><strong>50.000 x Reputation Points for Clan = 5 euro </strong></p>

<p>==========================================================</p>
<p><strong>10 x Festival Adena  </strong>= <strong>5 euro </strong> </p>
<p><strong>50 x Gold Einhasad  </strong>= <strong>5 euro </strong> </p>
<p><strong>500 x Silver Shilien  </strong>= <strong>5 euro </strong> </p>
<p><strong>5000 x Bloody Pa'agrio  </strong>= <strong>5 euro </strong> </p>
<p><strong>100 x Event - Apiga  </strong>= <strong>5 euro </strong> </p>
<p><strong>2500 x Lineage II Commemorative Mark  </strong>= <strong>5 euro </strong> </p>
<p><strong>5000 x WebPoints </strong>=<strong> 5 euro</strong></p>
<p>==========================================================</p>

<p><em><strong>THANK YOU! </strong></em></p>
<p>&nbsp;</p>
<p><strong>CONTACT DONATION ADMINISTRATOR:</strong></p>

<p>Forum name:80MXM08, in game: contact any GM <a href="mailto:antons007@gmail.com">antons007@gmail.com</a></p>
</div>
<?php
}
foot();
?>
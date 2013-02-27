<!DOCTYPE html>
<html>
	<head>
		<title>Build an Item</title>
		<link type="text/css" rel="stylesheet" href="/css/site.css" />
	</head>
	<body>
		<form action="get-url.php" method="get">
			<input type="hidden" name="which" value="build-item" />
			<fieldset>
				<select name="type">
					<option>ARMOR</option>
					<option>WEAPONS</option>
					<option>OTHER</option>
				</select>
				<!--  -->
				<select name="class">
					<optgroup label="head">
						<option value="helm">Helms</option>
						<option value="spirit-stone">Spirit Stones ( Monk )</option>
						<option value="voodoo-mask">Voodoo Masks ( Witch Doctor )</option>
						<option value="wizard-hat">Wizard Hats ( Wizzard )</option>
					</optgroup>
					<optgroup label="shoulders">
						<option value="pauldrons">Pauldrons</option>
					</optgroup>
					<optgroup label="torso">
						<option value="chest-armor">Chest Armor
						<option value="cloak">Cloaks ( Demon Hunter )</option>
					</optgroup>
					<optgroup label="Wrists">
						<option value="bracers">Bracers</option>
					</optgroup>
					<optgroup label="Hands">
						<option value="gloves">Gloves</option>
					</optgroup>
					<optgroup label="Waist">
						<option value="belt">Belts</option>
						<option value="mighty-belt">Mighty Belts ( Barbarian )</option>
					</optgroup>
					<optgroup label="Legs">
						<option value="pants">Pants</option>
					</optgroup>
					<optgroup label="Feet">
						<option value="boots">Boots</option>
					</optgroup>
					<optgroup label="Jewelry">
						<option value="amulet">Amulets</option>
						<option value="ring">Rings</option>
					</optgroup>
					<optgroup label="Off-Hand">
						<option value="shield">Shields</option>
						<option value="mojo">Mojos ( Witch Doctor )</option>
						<option value="orb">Orbs Wiz</option>
						<option value="quiver">Quivers ( Demon Hunter )</option>
					</optgroup>
					<optgroup label="Follower Special">
						<option value="enchantress-focus">Enchantress Focuses</option>
						<option value="scoundrel-token">Scoundrel Tokens</option>
						<option value="templar-relic">Templar Relics</option>
					</optgroup>
				</select>
				<select name="WEAPONS">
					<optgroup label="one-handed">
						<option value="axe-1h">Axes</option>
						<option value="dagger">Daggers</option>
						<option value="mace-1h">Maces</option>
						<option value="spear">Spears</option>
						<option value="sword-1h">Swords</option>
						<option value="ceremonial-knife">Ceremonial Knives ( Witch Doctor )</option>
						<option value="fist-weapon">Fist Weapons ( Monk )</option>
						<option value="mighty-weapon-1h">Mighty Weapons ( Barbarian )</option>
					</optgroup>
					<optgroup label="two-handed">
						<option value="axe-2h">Axes</option>
						<option value="mace-2h">Maces</option>
						<option value="polearm">Polearms</option>
						<option value="staff">Staves</option>
						<option value="sword-2h">Swords</option>
						<option value="daibo">Daibo ( Monk )</option>
						<option value="mighty-weapon-2h">Mighty Weapons ( Barbarian )</option>
					</optgroup>
					<optgroup label="ranged">
						<option value="bow">Bows</option>
						<option value="crossbow">Crossbows</option>
						<option value="hand-crossbow">Hand Crossbows ( Demon Hunter )</option>
						<option value="wand">Wands Wiz</option>
					</optgroup>
				</select>
				<!-- select name="OTHER">
					<optgroup label="Consumables">
						<option value="potion">Potions</option>
					</optgroup>
					<optgroup label="Crafting">
						<option value="crafting-material">Crafting Materials</option>
						<option value="blacksmith-plan">Blacksmith Plans</option>
						<option value="jeweler-design">Jeweler Designs</option>
						<option value="page-of-training">Pages of Training</option>
						<option value="dye">Dyes</option>
						<option value="gem">Gems</option>
						<option value="misc">Miscellaneous</option>
					</optgroup>
				</select -->
				<input type="submit" value="submit" />
			</fieldset>
		</form>
	</body>
</html>
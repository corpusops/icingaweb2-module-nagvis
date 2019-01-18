<?php

use Icinga\Application\Config;
use Icinga\Module\Nagvis\RestrictionHelper;

$section = $this->menuSection(N_('Maps'))
    ->setIcon('globe');

$section->add($this->translate('NagVis'))
    ->setUrl('nagvis/frontend/nagvis-js/index.php?mod=Map&act=view&show=automap');

$prio = 0;
$restriction = RestrictionHelper::getRegex();
foreach (Config::module('nagvis')->getSection('menu') as $name => $caption) {
    if ($restriction !== null && ! preg_match($restriction, $name)) {
        continue;
    }
    $section->add($caption, array(
        'url'           => 'nagvis/frontend/nagvis-js/index.php?mod=Map&act=view',
        'urlParameters' => array('show' => $name),
        'priority'      => ++$prio
    ));
}

$this->providePermission(
    'nagvis/edit',
    $this->translate('Modify NagVis maps')
);

$this->providePermission(
    'nagvis/admin',
    $this->translate('Nagvis administration')
);

$this->providePermission(
    'nagvis/overview',
    $this->translate('NagVis general overview')
);

$this->provideRestriction(
    'nagvis/map/filter',
    $this->translate('Filter NagVis maps')
);

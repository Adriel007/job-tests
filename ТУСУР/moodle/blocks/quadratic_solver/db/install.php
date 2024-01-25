<?php
defined('MOODLE_INTERNAL') || die();

function xmldb_block_quadratic_solver_install()
{
    global $DB;

    $table = new xmldb_table('quadratic_solver_results');

    $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
    $table->add_field('a', XMLDB_TYPE_NUMBER, '20, 10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('b', XMLDB_TYPE_NUMBER, '20, 10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('c', XMLDB_TYPE_NUMBER, '20, 10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('x1', XMLDB_TYPE_NUMBER, '20, 10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('x2', XMLDB_TYPE_NUMBER, '20, 10', null, XMLDB_NOTNULL, null, null);
    $table->add_field('timecreated', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, null);

    $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

    $dbman = $DB->get_manager();
    $dbman->create_table($table);
}
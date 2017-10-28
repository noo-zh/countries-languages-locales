#!/bin/bash

set -e

red=`tput setaf 1`
green=`tput setaf 2`
yellow=`tput setaf 3`
blue=`tput setaf 4`
magenta=`tput setaf 5`
cyan=`tput setaf 6`
white=`tput setaf 7`

rootdir=$PWD
php=/usr/bin/php

commands=()
commands[0]="TinyCountries --ds-multi-locale-alpha2"
commands[1]="TinyCountries --ds-multi-locale-alpha3"
commands[2]="TinyLanguages --ds-multi-locale-alpha2"
commands[3]="TinyLanguages --ds-multi-locale-locale"
commands[4]="TinyLanguages --ds-multi-locale-mixed"

show_commands()
{
  count=${#commands[@]}

  echo ""
  echo -n "$yellow"
  echo "Available exporters:"
  echo ""

  for (( index=0; index<count; index++ ))
  do
    echo "   $green$index. $magenta${commands[$index]}"
  done

  echo ""
  echo -n "$yellow"
  echo -n "Please choose the number: $cyan"
  read result

  if [ $result -ge 0 ] && [ $result -lt $count ] && [[ "$result" =~ ^[0-9]+$ ]]; then
    run_command $result
    echo ""

  else
    echo -n "$red"
    echo "Invalid input - stopped"
    echo ""
    exit 1
  fi
}

run_command()
{
  echo ""
  php lib/driver.php ${commands[$1]}
}

show_commands

exit 0
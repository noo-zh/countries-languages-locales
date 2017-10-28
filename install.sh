#!/bin/bash

set -e

rootdir=$PWD
sources=$rootdir/.sources

git_clone()
{
  if [ -d "$sources/$2" ]; then
    cd $sources/$2 && git fetch && git reset --hard $3
  else
    cd $sources && git clone $1
    cd $sources/$2 && git checkout $3 -b cll-devel
  fi
}

link_download()
{
  dir=$sources/$2
  file=$(basename "$1")

  if [ -d "$sources/$2" ]; then
    rm -r -d $dir
  fi

  mkdir $dir && cd $dir && wget $1 -O $file
}

# Clone gits

git_clone https://github.com/umpirsky/locale-list.git locale-list master
git_clone https://github.com/umpirsky/country-list.git country-list tags/2.0.2
git_clone https://github.com/mledoze/countries.git countries tags/v1.8.0
git_clone https://github.com/OpenBookPrices/country-data.git country-data tags/v0.0.31

# Download files

link_download https://pkgstore.datahub.io/core/language-codes:language-codes-3b2_csv/data/language-codes-3b2_csv.csv language-codes-3b2
link_download http://country.io/continent.json continents

exit 0
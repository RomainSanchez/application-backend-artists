<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Song;
use App\Utils\TokenGenerator;
use App\Utils\TimeConverter;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $json = file_get_contents("https://gist.githubusercontent.com/fightbulc/9b8df4e22c2da963cf8ccf96422437fe/raw/8d61579f7d0b32ba128ffbf1481e03f4f6722e17/artist-albums.json");
        $artistsArray = json_decode($json, true);

        foreach($artistsArray as $artistArray) {
            $artist = new Artist();

            $artist->setName($artistArray['name']);
            $artist->setToken(TokenGenerator::generate(6));

            $this->addAlbums($artist, $artistArray['albums']);

            $manager->persist($artist);
        }

        $manager->flush();
    }

    private function addAlbums(Artist $artist, array $albums) {
        foreach($albums as $albumArray) {
            $album = new Album();

            $album->setTitle($albumArray['title']);
            $album->setCover($albumArray['cover']);
            $album->setDescription($albumArray['description']);
            $album->setToken(TokenGenerator::generate(6));
            
            $this->addSongs($album, $albumArray['songs']);

            $artist->addAlbum($album);
        }
    }

    private function addSongs(Album $album, array $songs) {
        foreach($songs as $songArray) {
            $song = new song();

            $song->setTitle($songArray['title']);
            $song->setLength(TimeConverter::timeToSeconds($songArray['length']));
        }

        $album->addSong($song);
    }
}
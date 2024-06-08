use Gitter\Statitics\StatiticsInterface;
        $path = getenv('GIT_CLIENT') ?: null;
        $this->client = new Client($path);
    }

    public function tearDown ()
    {
        \Mockery::close();
    public function testIsNamesCorrect()
    {
        $a = $this->client->createRepository(self::$tmpdir . '/reponame');
        $b = $this->client->createRepository(self::$tmpdir . '/another-repo-name/');

        $this->assertEquals("reponame", $a->getName());
        $this->assertEquals("another-repo-name", $b->getName());
    }

        $repository->commit("The truth unveiled\n\nThis is a proper commit body");
        $this->assertRegExp("/This is a proper commit body/", $repository->getClient()->run($repository, 'log'));

        $commits = $repository->getCommits();
        $hash = $commits[0]->getHash();
        $repository->checkout($hash);
        $new_branch = $repository->getCurrentBranch();
        $this->assertTrue($new_branch === NULL);

        $repository->checkout($branch);
    }

    public function testIsGettingBranchesWhenHeadIsDetached()
    {
        $repository = $this->client->getRepository(self::$tmpdir . '/testrepo');
        $commits = $repository->getCommits();
        $current_branch = $repository->getCurrentBranch();
        $hash = $commits[0]->getHash();
        $repository->checkout($hash);
        $branches = $repository->getBranches();
        $this->assertTrue(count($branches) === 3);

        $branch = $repository->getHead('develop');
        $repository->checkout($current_branch);
            $this->assertTrue($commit->isCommit());
            $this->assertEquals($commit->getMessage(), 'The truth unveiled');
            $this->assertTrue($commit->isCommit());
            $this->assertTrue($file->isBlob());
            $this->assertTrue($singleCommit->isCommit());

            if ($singleCommit->getMessage() == 'The truth unveiled') {
                $this->assertEquals($singleCommit->getBody(), 'This is a proper commit body');
            }
    public function testIsAddingFileNameWithSpace()
    {
        $repository = $this->client->getRepository(self::$tmpdir . '/testrepo');
        file_put_contents(self::$tmpdir . '/testrepo/test file10.txt', 'Your mother is so ugly, glCullFace always returns TRUE.');
        $repository->add('test file10.txt');

        $this->assertRegExp("/new file:   test file10.txt/", $repository->getClient()->run($repository, 'status'));
    }

    public function testCommitWithFileNameWithSpace()
    {
        $repo = $this->client->createRepository(self::$tmpdir . '/testrepospace');
        $diffs = $repo->readDiffLogs($this->getLogsForCommitWithFileNameWithSpace());

        $this->assertEquals('test file.txt', $diffs[0]->getFile(), 'New file name with a space in it');
        $this->assertEquals('testfile.txt', $diffs[1]->getFile(), 'Old file name');
	}

    public function testIsAddingSingleStatistics ()
    {
        $statisticsMock = \Mockery::mock('Gitter\Statistics\StatiticsInterface');
        $statisticsMock->shouldReceive('sortCommits')->once();
        
        $repo = $this->client->createRepository(self::$tmpdir . '/teststatsrepo');
        $repo->addStatistics($statisticsMock);
        $repo->setCommitsHaveBeenParsed(true);

        $this->assertEquals(
            array(strtolower(get_class($statisticsMock)) => $statisticsMock),
            $repo->getStatistics(),
            'Failed to add single statistics'
        );
    }


    private function getLogsForCommitWithFileNameWithSpace()
    {
        // 'testfile.txt' is renamed to 'test file.txt'
        return array(
            'diff --git a/test file.txt b/test file.txt',
            'new file mode 100644',
            'index 0000000..63edbe7',
            '--- /dev/null',
            '+++ b/test file.txt',
            '@@ -0,0 +1 @@',
            '+Modified line',
            'diff --git a/testfile.txt b/testfile.txt',
            'deleted file mode 100644',
            'index 63edbe7..0000000',
            '--- a/testfile.txt',
            '+++ /dev/null',
            '@@ -1 +0,0 @@',
            '-Modified line',
        );
    }
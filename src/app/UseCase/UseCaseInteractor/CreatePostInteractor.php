<?php

namespace App\UseCase\UseCaseInteractor;

use App\UseCase\UseCaseInput\CreatePostInput;
use App\UseCase\UseCaseOutput\CreatePostOutput;
use App\Domain\Port\IPostCommand;
use App\Domain\Entity\Post;
use App\Domain\ValueObject\Category\CategoryId;

final class CreatePostInteractor
{
    const COMPLETED_MESSAGE = "投稿が完了しました";

    private $postCommand;
    private $input;

    public function __construct(IPostCommand $postCommand, CreatePostInput $input)
    {
        $this->postCommand = $postCommand;
        $this->input = $input;
    }

    public function handle(): CreatePostOutput
    {
        $categoryId = new CategoryId($this->input->getCategoryId());

        $post = new Post(
            $this->input->getContents(),
            $this->input->getDeadline(),
            $categoryId,
            $this->input->getUserId()
        );

        $postId = $this->postCommand->save($post);

        return new CreatePostOutput($postId, self::COMPLETED_MESSAGE);
    }
}
?>
<?php

namespace Source\Models;

use Source\Core\Connect;

class Faq
{
    private $question;
    private $answer;
    private $message;

    /**
     * @return mixed|null
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed|null $question
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }

    /**
     * @return mixed|null
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed|null $answer
     */
    public function setAnswer($answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }


    /**
     * @param $question
     * @param $answer
     */
    public function __construct($question = null, $answer = null)
    {
        $this->question = $question;
        $this->answer = $answer;
    }

    public function selectAll ()
    {
        $query = "SELECT * FROM faqs";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();

        if($stmt->rowCount() == 0){
            return false;
        } else {
            return $stmt->fetchAll();
        }
    }

    public function insert()
    {
        $query = "INSERT INTO faqs (question, answer) 
                  VALUES(:question, :answer)";
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->bindParam(":question", $this->question);
        $stmt->bindParam(":answer", $this->answer);
        $stmt->execute();
        $this->message = "FAQ cadastrada com sucesso!";
        return true;
    }

}
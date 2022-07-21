<?php

use App\Core\Mailer;

class Subject implements \SplSubject
{
  public $state;
  private $observers;

  public function __construct()
  {
    $this->observers = new \SplObjectStorage();
  }

  public function attach(\SplObserver $observer): void
  {
    echo "Subject: Attached an observer.\n";
    $this->observers->attach($observer);
  }

  public function detach(\SplObserver $observer): void
  {
    $this->observers->detach($observer);
    echo "Subject: Detached an observer.\n";
  }

  public function notify(): void
  {
    // send mail
    $mailer = new Mailer();
    $mailer->send($this->state->user->getEmail(), $this->state->subject, $this->state->message);
    // notify observers
    foreach ($this->observers as $observer) {
      $observer->update($this);
    }
  }
}

class ConcreteObserverA implements \SplObserver
{
  public function update(\SplSubject $subject): void
  {
    if ($subject->state < 3) {
      echo "ConcreteObserverA: Reacted to the event.\n";
    }
  }
}

class ConcreteObserverB implements \SplObserver
{
  public function update(\SplSubject $subject): void
  {
    if ($subject->state == 0 || $subject->state >= 2) {
      echo "ConcreteObserverB: Reacted to the event.\n";
    }
  }
}

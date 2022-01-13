<?php
/**
 * MessageListEvent.php
 * avanzu-admin
 * Date: 23.02.14
 */

namespace Avanzu\AdminThemeBundle\Event;

use Avanzu\AdminThemeBundle\Model\MessageInterface;

/**
 * The MessageListEvent should be used with the {@link ThemeEvents::THEME_MESSAGES}
 * in order to collect all {@link MessageInterface} objects that should be rendered in the messages section.
 *
 */
class MessageListEvent extends ThemeEvent
{
    /**
     * Stores the list of messages
     */
    protected array $messages = [];

    /**
     * Stores the total amount
     */
    protected int $totalMessages = 0;

    protected int $max           = 0;

    /**
     * MessageListEvent constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get the maximum number of notifications displayed in panel
     */
    public function getMax(): int
    {
        return $this->max;
    }

    /**
     * Returns the message list
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    /**
     * Pushes the given message to the list of messages.
     *
     * @param MessageInterface $messageInterface
     *
     * @return $this
     */
    public function addMessage(MessageInterface $messageInterface)
    {
        $this->messages[] = $messageInterface;

        return $this;
    }

    /**
     * Returns the message count
     */
    public function getTotal(): int
    {
        return $this->totalMessages === 0 ? count($this->messages) : $this->totalMessages;
    }
}

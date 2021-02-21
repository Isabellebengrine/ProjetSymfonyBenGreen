<?php

namespace App\Storage;

use App\Entity\Totalorder;
use App\Repository\TotalorderRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CartSessionStorage
 * @package App\Storage
 */
class CartSessionStorage
{
    /**
     * The session storage.
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * The cart repository.
     *
     * @var TotalorderRepository
     */
    private $cartRepository;

    /**
     * @var string
     */
    const CART_KEY_NAME = 'cart_id';

    /**
     * CartSessionStorage constructor.
     *
     * @param SessionInterface $session
     * @param TotalorderRepository $cartRepository
     */
    public function __construct(SessionInterface $session, TotalorderRepository $cartRepository)
    {
        $this->session = $session;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Gets the cart in session.
     *
     * @return Totalorder|null
     */
    public function getCart(): ?Totalorder
    {
        return $this->cartRepository->findOneBy([
            'id' => $this->getCartId(),
            'status' => Totalorder::STATUS_CART
        ]);
    }

    /**
     * Sets the cart in session.
     *
     * @param Totalorder $cart
     */
    public function setCart(Totalorder $cart): void
    {
        $this->session->set(self::CART_KEY_NAME, $cart->getId());
    }

    /**
     * Returns the cart id.
     *
     * @return int|null
     */
    private function getCartId(): ?int
    {
        return $this->session->get(self::CART_KEY_NAME);
    }
}

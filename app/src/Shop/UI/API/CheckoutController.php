<?php

declare(strict_types=1);

namespace App\Shop\UI\API;

use App\Admin\Application\Service\FileService;
use App\Cart\Infrastructure\Repository\CartDoctrineRepository;
use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Entity\Order;
use App\Common\Domain\Entity\PaymentMethod;
use App\Order\Infrastructure\Repository\OrderDoctrineRepository;
use App\Shared\Application\DTO\Response\ApiResponse;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\Enums\CookieName;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use App\Shop\Application\DTO\Request\Checkout\SaveCheckoutAddressRequest;
use App\Shop\Application\UseCase\Checkout\ConfirmationOrderUseCase;
use App\Shop\Application\UseCase\Checkout\SaveCarrierUseCase;
use App\Shop\Application\UseCase\Checkout\SaveCheckoutAddressUseCase;
use App\Shop\Application\UseCase\Checkout\SavePaymentMethodUseCase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/checkout', name: 'checkout_')]
class CheckoutController extends AbstractController
{
    public function __construct(
        private readonly RequestDtoResolver      $requestDtoResolver,
        private readonly CartDoctrineRepository  $cartRepository,
        private readonly OrderDoctrineRepository $orderRepository,
        private readonly EntityManagerInterface  $entityManager,
    ){
    }

    #[Route('/save-address', name: 'save_address', methods: ['POST'])]
    public function saveAddress(Request $request, SaveCheckoutAddressUseCase $useCase): JsonResponse
    {
        $cart = $this->cartRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
        if (!$cart) {
            throw $this->createNotFoundException();
        }

        $addressRequest = $this->requestDtoResolver->mapAndValidate($request, SaveCheckoutAddressRequest::class);

        $useCase->execute($addressRequest, $cart, $this->getOrderByRequest($request));

        return $this->json(new ApiResponse());
    }

    #[Route('/save-carrier/{carrierId}', name: 'save_carrier', methods: ['POST'])]
    public function saveCarrier(
        #[MapEntity(mapping: ['carrierId' => 'id'])] Carrier $carrier,
        Request $request,
        SaveCarrierUseCase $useCase
    ): JsonResponse
    {
        $order = $this->getOrderByRequest($request);
        if (null === $order) {
            throw $this->createNotFoundException();
        }

        $useCase->execute($carrier, $order);

        return $this->json(new ApiResponse());
    }

    #[Route('/save-payment/{paymentMethodId}', name: 'save_payment', methods: ['POST'])]
    public function savePayment(
        #[MapEntity(mapping: ['paymentMethodId' => 'id'])] PaymentMethod $paymentMethod,
        Request $request,
        SavePaymentMethodUseCase $useCase
    ): JsonResponse
    {
        $order = $this->getOrderByRequest($request);
        if (null === $order) {
            throw $this->createNotFoundException();
        }

        $useCase->execute($paymentMethod, $order);

        return $this->json(new ApiResponse());
    }

    #[Route('/payment/form-options', name: 'payment_form_options', methods: ['GET'])]
    public function getPaymentOptions(Request $request, MoneyFactory $factory, FileService $service): JsonResponse
    {
        $order = $this->getOrderByRequest($request);
        if (null === $order) {
            throw $this->createNotFoundException();
        }

        $paymentMethods = $this->entityManager->getRepository(PaymentMethod::class)->findBy([], ['order' => 'DESC']);

        $data = array_map(function (PaymentMethod $paymentMethod) use ($factory, $service) {
            return [
                'id' => $paymentMethod->getId(),
                'name' => $paymentMethod->getName(),
                'fee' => $factory->create($paymentMethod->getFee())->getFormattedAmountWithSymbol(),
                'image' => $service->preparePublicPathToFile($paymentMethod->getImage()?->getPath()),
            ];
        }, $paymentMethods);

        return $this->json(
            data: new ApiResponse([
                'paymentMethods' => $data
            ])
        );
    }

    #[Route('/carriers/form-options', name: 'carriers_form_options', methods: ['GET'])]
    public function getCarrierOptions(Request $request, MoneyFactory $factory, FileService $service): JsonResponse
    {
        $order = $this->getOrderByRequest($request);
        if (null === $order) {
            throw $this->createNotFoundException();
        }

        $carriers = $this->entityManager->getRepository(Carrier::class)->findAll();

        $data = array_map(function (Carrier $carrier) use ($factory, $service) {
            return [
                'id' => $carrier->getId(),
                'name' => $carrier->getName(),
                'fee' => $factory->create($carrier->getFee())->getFormattedAmountWithSymbol(),
                'deliveryTime' => '',
                'image' => $service->preparePublicPathToFile($carrier->getImage()?->getPath()),
            ];
        }, $carriers);

        return $this->json(
            data: new ApiResponse([
                'carriers' => $data,
            ])
        );
    }

    #[Route('/confirmation/data', name: 'confirmation_data', methods: ['GET'])]
    public function getOrderForConfirmationStep(Request $request,  MoneyFactory $factory, FileService $service): JsonResponse
    {
        $order = $this->getOrderByRequest($request);
        if (null === $order) {
            throw $this->createNotFoundException();
        }

        $isInvoice = $order->getInvoiceAddress() !== null;

        $data = [
            'addressStep' => [
                'delivery' => [
                    'street' => $order->getDeliveryAddress()->getAddress()->getStreet(),
                    'postalCode' => $order->getDeliveryAddress()->getAddress()->getPostalCode(),
                    'city' => $order->getDeliveryAddress()->getAddress()->getCity(),
                    'deliveryInstructions' => $order->getDeliveryAddress()->getDeliveryInstructions(),
                    'firstname' => $order->getContactDetails()->getFirstname(),
                    'surname' => $order->getContactDetails()->getSurname(),
                    'phone' => $order->getContactDetails()->getPhone(),
                    'email' => $order->getContactDetails()->getEmail(),
                ],
                'isInvoice' => $isInvoice,
                'invoice' => $isInvoice ? [
                    'street' => $order->getInvoiceAddress()->getAddress()->getStreet(),
                    'postalCode' => $order->getInvoiceAddress()->getAddress()->getPostalCode(),
                    'city' => $order->getInvoiceAddress()->getAddress()->getCity(),
                    'companyName' => $order->getInvoiceAddress()->getCompanyName(),
                    'companyTaxId' => $order->getInvoiceAddress()->getCompanyTaxId()
                ] : []
            ],
            'carrierStep' => [
                'name' => $order->getCarrier()->getName(),
                'fee' => $factory->create($order->getCarrier()->getFee())->getFormattedAmountWithSymbol(),
                'image' => $service->preparePublicPathToFile($order->getCarrier()->getImage()?->getPath()),
                'deliveryTime' => 'deliveryTime',
            ],
            'paymentStep' => [
                'name' => '$order->getPayments()->first()->getPaymentMethod()->getName()',
                'fee' => '$order->getPayments()->first()->getPaymentMethod()->getFee()',
                'image' => '$order->getPayments()->first()->getPaymentMethod()->getImage()',
            ],
        ];

        return $this->json(
            data: new ApiResponse([
                'data' => $data
            ])
        );
    }

    #[Route('/confirmation/', name: 'confirmation', methods: ['POST'])]
    public function confirmationOrder(Request $request, ConfirmationOrderUseCase $useCase): JsonResponse
    {
        $order = $this->getOrderByRequest($request);
        if (null === $order) {
            throw $this->createNotFoundException();
        }

        $useCase->execute($order);

        return $this->json(new ApiResponse());
    }

    private function getOrderByRequest(Request $request): ?Order
    {
        $order = $this->orderRepository->findByToken($request->cookies->get(CookieName::SHOP_CART->value));
        return $order ?? null;
    }
}

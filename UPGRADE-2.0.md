# UPGRADE FROM `1.14` TO `2.0`

## Configuration

* Messenger:
    * The `sylius_default.bus` and `sylius_event.bus` configuration options were removed. Use `sylius.command_bus` and
      `sylius.event_bus` for commands and events respectively.

## Codebase

* Doctrine MongoDB and PHPCR is no longer supported in ResourceBundle and GridBundle:

* The following classes were removed:

    * `Sylius\Bundle\ApiBundle\EventListener\PostgreSQLDriverExceptionListener`
    * `Sylius\Bundle\GridBundle\Doctrine\PHPCRODM\DataSource`
    * `Sylius\Bundle\GridBundle\Doctrine\PHPCRODM\Driver`
    * `Sylius\Bundle\GridBundle\Doctrine\PHPCRODM\ExpressionBuilder`
    * `Sylius\Bundle\GridBundle\Doctrine\PHPCRODM\ExpressionBuilderInterface`
    * `Sylius\Bundle\GridBundle\Doctrine\PHPCRODM\ExpressionVisitor`
    * `Sylius\Bundle\GridBundle\Doctrine\PHPCRODM\ExtraComparison`
    * `Sylius\Bundle\ResourceBundle\DependencyInjection\Driver\Doctrine\DoctrineODMDriver`
    * `Sylius\Bundle\ResourceBundle\DependencyInjection\Driver\Doctrine\DoctrinePHPCRDriver`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\MongoDB\DocumentRepository`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\MongoDB\TranslatableRepository`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\PHPCR\DocumentRepository`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\PHPCR\EventListener\DefaultParentListener`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\PHPCR\EventListener\NameFilterListener`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\PHPCR\EventListener\NameResolverListener`
    * `Sylius\Bundle\ResourceBundle\Doctrine\ODM\PHPCR\Form\Builder\DefaultFormBuilder`
    * `Sylius\Bundle\ResourceBundle\EventListener\ODMMappedSuperClassSubscriber`
    * `Sylius\Bundle\ResourceBundle\EventListener\ODMRepositoryClassSubscriber`
    * `Sylius\Bundle\ResourceBundle\EventListener\ODMTranslatableListener`

* The following services were removed:

    * `sylius.event_subscriber.odm_mapped_super_class`
    * `sylius.event_subscriber.odm_repository_class`
    * `sylius.grid_driver.doctrine.phpcrodm`
    * `sylius.listener.api_postgresql_driver_exception_listener`

* The following parameters were removed:

    * `sylius.mongodb_odm.repository.class`
    * `sylius.phpcr_odm.repository.class`
    
* The following parameters were renamed:

    * `sylius.message.admin_user_create.validation_groups` to `sylius_admin.command_handler.create_admin_user.validation_groups`

* The following configuration options were removed:

    * `sylius.mailer.templates`

* Added the `Sylius\Component\Order\Context\ResettableCartContextInterface` that
  extends `Sylius\Component\Order\Context\CartContextInterface` and `Symfony\Contracts\Service\ResetInterface`.

* The name of the default `LiipImagineBundle`'s resolver and loader were changed from **default** to **sylius_image
  ** ([reference](https://github.com/Sylius/Sylius/pull/12543)).
  To change the default resolver and/or loader for `LiipImagineBundle`, configure `cache` and/or `data_loader`
  parameters under the `liip_imagine` key.

* The `sylius/calendar` package has been replaced with `symfony/clock` package. All usages of
  the `Sylius\Calendar\Provider\DateTimeProviderInterface` class
  have been replaced with `Symfony\Component\Clock\ClockInterface` class.

    * The following classes were changed:

        * `Sylius\Bundle\CoreBundle\CatalogPromotion\Announcer\CatalogPromotionAnnouncer`
        * `Sylius\Bundle\CoreBundle\MessageHandler\Admin\Account\RequestResetPasswordEmailHandler`
        * `Sylius\Bundle\CoreBundle\PriceHistory\Logger\PriceChangeLogger`
        * `Sylius\Bundle\CoreBundle\PriceHistory\Remover\ChannelPricingLogEntriesRemover`
        * `Sylius\Bundle\ShippingBundle\Assigner\ShippingDateAssigner`
        * `Sylius\Bundle\PromotionBundle\Criteria\DateRange`
        * `Sylius\Bundle\ApiBundle\Applicator\ArchivingShippingMethodApplicator`
        * `Sylius\Bundle\ApiBundle\CommandHandler\Account\RequestResetPasswordTokenHandler`
        * `Sylius\Bundle\ApiBundle\CommandHandler\Account\VerifyCustomerAccountHandler`
        * `Sylius\Component\Taxation\Checker\TaxRateDateEligibilityChecker`

* The parameter order of `Sylius\Bundle\CoreBundle\Form\Type\Checkout\AddressType::__construct` has been changed:

    ```php
        public function __construct(
        +   private readonly AddressComparatorInterface $addressComparator,
            string $dataClass,
            array $validationGroups = []
        -   private readonly AddressComparatorInterface $addressComparator = null,
        )
    ```

* The `\Serializable` interface has been removed from the `Sylius\Component\User\Model\UserInterface`.

* The parameter order of the `Sylius\Component\Core\OrderProcessing\OrderPaymentProcessor::__construct` has been
  changed:

    ```php
        public function __construct(
            private OrderPaymentProviderInterface $orderPaymentProvider,
        -   private string $targetState = PaymentInterface::STATE_CART,
            private OrderPaymentsRemoverInterface $orderPaymentsRemover,
            private array $unprocessableOrderStates,
        +   private string $targetState = PaymentInterface::STATE_CART,
        )
    ```

* The `swiftmailer/swiftmailer` dependency has been removed. Use `symfony/mailer` instead.

* The following repository classes and interfaces were added, if you have custom repositories,
  you need to update them to extend the new ones:

  Addressing:

    * `Sylius\Bundle\AddressingBundle\Doctrine\ORM\AddressRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Addressing\Repository\AddressRepositoryInterface`
    * `Sylius\Bundle\AddressingBundle\Doctrine\ORM\CountryRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Addressing\Repository\CountryRepositoryInterface`
    * `Sylius\Bundle\AddressingBundle\Doctrine\ORM\ProvinceRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Addressing\Repository\ProvinceRepositoryInterface`
    * `Sylius\Bundle\AddressingBundle\Doctrine\ORM\ZoneMemberRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Addressing\Repository\ZoneMemberRepositoryInterface`

  Attribute:

    * `Sylius\Bundle\AttributeBundle\Doctrine\ORM\AttributeRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Attribute\Repository\AttributeRepositoryInterface`
    * `Sylius\Bundle\AttributeBundle\Doctrine\ORM\AttributeTranslationRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Attribute\Repository\AttributeTranslationRepositoryInterface`
    * `Sylius\Bundle\AttributeBundle\Doctrine\ORM\AttributeValueRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Attribute\Repository\AttributeValueRepositoryInterface`
  
  Product:

    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductAssociationRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductAssociationTypeTranslationRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductAttributeRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductAttributeTranslationRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductOptionTranslationRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductOptionValueRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductOptionValueTranslationRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductTranslationRepository`
    * `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductVariantTranslationRepository`

  Currency:

    * `Sylius\Bundle\CurrencyBundle\Doctrine\ORM\CurrencyRepository`
      extends `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository`
      implements `Sylius\Component\Currency\Repository\CurrencyRepositoryInterface`

* The following repository classes and interfaces namespaces were changed, if you have custom repositories,
  you need to update them to extend the new ones:

  Addressing:

    * `Sylius\Bundle\CoreBundle\Doctrine\ORM\AddressRepository` extended class changed from
      `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository` to
      `Sylius\Bundle\AddressingBundle\Doctrine\ORM\AddressRepository`
    * `Sylius\Component\Core\Repository\AddressRepositoryInterface` implemented interface changed from
      `Sylius\Component\Resource\Repository\RepositoryInterface` to
      `Sylius\Component\Addressing\Repository\AddressRepositoryInterface`

  Attribute:

    * `Sylius\Bundle\CoreBundle\Doctrine\ORM\AttributeRepository` extended class changed from
      `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository` to
      `Sylius\Bundle\AttributeBundle\Doctrine\ORM\AttributeRepository`
    * `Sylius\Component\Product\Repository\ProductAttributeValueRepositoryInterface` extended interface changed from
      `Sylius\Component\Resource\Repository\RepositoryInterface` to
      `Sylius\Component\Attribute\Repository\AttributeValueRepositoryInterface`
  
  Product:

    * `Sylius\Bundle\CoreBundle\Doctrine\ORM\ProductAssociationRepository` extended class changed from
      `Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository` to
      `Sylius\Bundle\ProductBundle\Doctrine\ORM\ProductAssociationRepository`

* A new parameter has been added to specify the validation groups for a given zone.
  If you have any custom validation groups for zone member, you need to add them to
  your `config/packages/_sylius.yaml` file.
  This is handled by `Sylius\Bundle\AddressingBundle\Validator\Constraints\ZoneMemberGroup` and it resolves the groups
  based on the type of the passed zone.

* The following constructor parameter has been changed across the codebase:

    ```php
    -   private StateMachineInterface $stateMachineFactory,
    +   private StateMachineInterface $stateMachine,
    ```    

  ```yaml
  sylius_addressing:
    zone_member:
      validation_groups:
        country:
          - 'sylius'
          - 'sylius_zone_member_country'
        zone:
          - 'sylius'
          - 'sylius_zone_member_zone'
  ```

* The following classes and interfaces have been removed:

  Money:

    * `Sylius\Bundle\MoneyBundle\Templating\Helper\ConvertMoneyHelper`
    * `Sylius\Bundle\MoneyBundle\Templating\Helper\ConvertMoneyHelperInterface`
    * `Sylius\Bundle\MoneyBundle\Templating\Helper\FormatMoneyHelper`
    * `Sylius\Bundle\MoneyBundle\Templating\Helper\FormatMoneyHelperInterface`

### Constructors signature changes

1. The following constructor signatures have been changed:

   `Sylius\Bundle\MoneyBundle\Twig\ConvertMoneyExtension`
    ```diff
    use Sylius\Component\Currency\Converter\CurrencyConverterInterface;

        public function __construct(
    -       private ConvertMoneyHelperInterface|CurrencyConverterInterface $helper,
    +       private CurrencyConverterInterface $currencyConverter,
        )
    ```

   `Sylius\Bundle\MoneyBundle\Twig\FormatMoneyExtension`
    ```diff
    use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatterInterface;

        public function __construct(
    -       private private FormatMoneyHelperInterface|MoneyFormatterInterface $helper,
    +       private MoneyFormatterInterface $moneyFormatter,
        )
    ```

## Password Encoder & Salt
The encoder and salt has been removed from the User entities. It will use the password hasher configured on Symfony security configuration.

This "encoder" is configured via the [Symfony security password hasher](https://symfony.com/doc/current/security/passwords.html#configuring-a-password-hasher).

You may have already something like that configuration bellow.

```yaml
# config/packages/security.yaml
security:
    # ...

    password_hashers:
        Sylius\Component\User\Model\UserInterface: argon2i
```

Check if you have an encoder configured in the `sylius_user` package configuration.

```yaml
sylius_user:
    # ...
    
    encoder: plaintext # Remove this line

    # ...
    resources:
        oauth:
            user:
                encoder: false # Remove this line
                classes: Sylius\Component\User\Model\UserOAuth
```

Check your user hashed passwords in your production database.
In modern Symfony projects, the hasher name is stored on the password.

Example:
`$argon2i$v=19$m=65536,t=4,p=1$VVJuMnpUUWhRY1daN1ppMA$2Tx6l3I+OUx+PUPn+vZz1jI3Z6l6IHh2kpG0NdpmYWE`

If some of your users do not have the hasher name stored in the password field you may need to configure the "migrate_from" option into Symfony, following that documentation:
https://symfony.com/doc/current/security/passwords.html#configure-a-new-hasher-using-migrate-from

Note:
If your app never changed the hasher name configuration, you don't need to configure this "migrate_from" configuration.

## Frontend

* `use_webpack` option was removed from the `sylius_ui` configuration, and the Webpack has become the only module
  bundler provided by Sylius.
* `use_webpack` twig global variable was removed. Webpack is always used now, and there is no need to check for it.

## Payment method gateways

* Stripe gateway has been removed. This implementation has been deprecated and not SCA Ready.
* PayPal Express Checkout gateway has been removed. Use now [PayPal Commerce Platform](https://github.com/Sylius/PayPalPlugin) integration.

<?php
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\RelationalTypeResolverInterface;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoPSchema\Users\TypeResolvers\ObjectType\UserObjectTypeResolver;

class ObjectTypeFieldResolver_CommunityUsers extends AbstractObjectTypeFieldResolver
{
    use CommunityObjectTypeFieldResolverTrait;

    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            UserObjectTypeResolver::class,
        ];
    }

    public function getFieldNamesToResolve(): array
    {
        return [
            'members',
            'hasMembers',
        ];
    }

    public function getSchemaFieldType(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): string
    {
        $types = [
            'hasMembers' => SchemaDefinition::TYPE_BOOL,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($relationalTypeResolver, $fieldName);
    }

    public function getSchemaFieldTypeModifiers(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?int
    {
        return match($fieldName) {
            'hasMembers' => SchemaTypeModifiers::NON_NULLABLE,
            'members' => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
            default => parent::getSchemaFieldTypeModifiers($relationalTypeResolver, $fieldName),
        };
    }

    public function getSchemaFieldDescription(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'members' => $translationAPI->__('', ''),
            'hasMembers' => $translationAPI->__('', ''),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($relationalTypeResolver, $fieldName);
    }

    /**
     * @param array<string, mixed> $fieldArgs
     * @param array<string, mixed>|null $variables
     * @param array<string, mixed>|null $expressions
     * @param array<string, mixed> $options
     */
    public function resolveValue(
        RelationalTypeResolverInterface $relationalTypeResolver,
        object $object,
        string $fieldName,
        array $fieldArgs = [],
        ?array $variables = null,
        ?array $expressions = null,
        array $options = []
    ): mixed {
        $user = $object;
        switch ($fieldName) {
            case 'members':
                return URE_CommunityUtils::getCommunityMembers($relationalTypeResolver->getID($user));

            case 'hasMembers':
                return !empty($relationalTypeResolver->resolveValue($user, 'members', $variables, $expressions, $options));
        }

        return parent::resolveValue($relationalTypeResolver, $object, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function getFieldTypeResolverClass(RelationalTypeResolverInterface $relationalTypeResolver, string $fieldName): ?string
    {
        switch ($fieldName) {
            case 'members':
                return UserObjectTypeResolver::class;
        }

        return parent::getFieldTypeResolverClass($relationalTypeResolver, $fieldName);
    }
}

// Static Initialization: Attach
(new ObjectTypeFieldResolver_CommunityUsers())->attach(\PoP\ComponentModel\AttachableExtensions\AttachableExtensionGroups::OBJECT_TYPE_FIELD_RESOLVERS);

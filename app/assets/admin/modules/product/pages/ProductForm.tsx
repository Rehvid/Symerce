import { useForm, UseFormSetValue } from 'react-hook-form';
import ProductFormBody from '@admin/modules/product/components/ProductFormBody';
import useApiFormSubmit from '@admin/common/hooks/form/useApiFormSubmit';
import useFormInitializer from '@admin/common/hooks/form/useFormInitializer';
import FormSkeleton from '@admin/common/components/skeleton/FormSkeleton';
import { useEffect } from 'react';
import { AttributeItem, ProductFormData } from '@admin/modules/product/interfaces/ProductFormData';
import FormApiLayout from '@admin/layouts/FormApiLayout';
import FormWrapper from '@admin/common/components/form/FormWrapper';
import { FieldModifier } from '@admin/common/types/fieldModifier';

const ProductForm = () => {
    const { getRequestConfig, defaultApiSuccessCallback, entityId, isEditMode } = useApiFormSubmit({
        baseApiUrl: 'admin/products',
        redirectSuccessUrl: '/admin/products',
    });
    const {
        register,
        handleSubmit,
        setValue,
        setError,
        control,
        watch,
        formState: { errors: fieldErrors },
    } = useForm<ProductFormData>({
        mode: 'onBlur',
        defaultValues: {
            promotionSource: 'product_tab',
            id: entityId
        },
    });

    const requestConfig = getRequestConfig();

    const { isFormInitialize, formData, formContext, getFormData } = useFormInitializer<ProductFormData>();

    const modifySubmitValues = (values: ProductFormData) => {
        const modifyValues = { ...values };

        if (modifyValues?.attributes) {
            const newAttributes: Record<string, AttributeItem[]> = {};

            Object.entries(modifyValues.attributes).forEach(([key, attributeObj]) => {
                const values: AttributeItem[] = [];

                if (typeof attributeObj === 'object') {
                    Object.values(attributeObj).forEach((innerValue) => {
                        const isCustom = !!modifyValues.customAttributes?.[key];
                        values.push({
                            value: innerValue?.value ?? innerValue,
                            isCustom,
                        });
                    });
                }

                newAttributes[key] = values;
            });

            modifyValues.attributes = newAttributes;

            delete modifyValues.customAttributes;
        }

        if (modifyValues?.stocks) {
            modifyValues?.stocks.map((stock) => {
                const restockDate = stock.restockDate;

                stock.restockDate = restockDate ? restockDate : null;
                return stock;
            });
        }

        return modifyValues;
    };

    const getFormFieldNames = (hasId: boolean): (keyof ProductFormData)[] => {
        if (!hasId) return [];
        return [
            'name',
            'slug',
            'metaTitle',
            'metaDescription',
            'description',
            'isActive',
            'mainCategory',
            'categories',
            'tags',
            'brand',
            'stocks',
            'attributes',
            'regularPrice',
            'promotionIsActive',
            'promotionDateRange',
            'promotionReduction',
            'promotionReductionType',
        ];
    };

    const getFormFieldModifiers = (
        setValue: UseFormSetValue<ProductFormData>,
    ): FieldModifier<ProductFormData>[] => [
        {
            fieldName: 'attributes',
            action: (attributesByKey: Record<string, AttributeItem[]>) => {
                Object.entries(attributesByKey).forEach(([attributeGroupKey, attributeItems]) => {
                    let isCustom = false;

                    attributeItems.forEach((attributeItem, itemIndex) => {
                        isCustom = attributeItem.isCustom;

                        if (isCustom) {
                            setValue(
                                `attributes.${attributeGroupKey}.${itemIndex}.value` as any,
                                attributeItem.value
                            );
                        } else {
                            setValue(
                                `attributes.${attributeGroupKey}.${itemIndex}` as any,
                                attributeItem.value
                            );
                        }
                    });

                    setValue(`customAttributes.${attributeGroupKey}` as any, isCustom);
                });
            }
        },
    ];


    useEffect(() => {
        getFormData(
            isEditMode ? `admin/products/${entityId}` : 'admin/products/store-data',
            setValue,
            getFormFieldNames(isEditMode),
            getFormFieldModifiers(setValue)
        );
    }, []);

    if (!isFormInitialize) {
        return <FormSkeleton rowsCount={12} />;
    }

    return (
        <FormWrapper
            method={requestConfig.method}
            endpoint={requestConfig.endpoint}
            handleSubmit={handleSubmit}
            setError={setError}
            apiRequestCallbacks={defaultApiSuccessCallback}
            modifySubmitValues={modifySubmitValues}
        >
            <FormApiLayout pageTitle={isEditMode ? 'Edytuj Produkt' : 'Dodaj Produkt'}>
                <ProductFormBody
                    register={register}
                    control={control}
                    watch={watch}
                    setValue={setValue}
                    fieldErrors={fieldErrors}
                    formData={formData}
                    formContext={formContext}
                />
            </FormApiLayout>
        </FormWrapper>
    );
};

export default ProductForm;

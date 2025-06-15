import React from 'react';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import { FieldErrors, UseFormRegister } from 'react-hook-form';
import { OrderFormData } from '@admin/modules/order/interfaces/OrderFormData';
import FormSection from '@admin/common/components/form/FormSection';
import Phone from '@admin/common/components/form/fields/Phone';
import Email from '@admin/common/components/form/fields/Email';
import Firstname from '@admin/common/components/form/fields/Firstname';
import Surname from '@admin/common/components/form/fields/Surname';
import ContactDetailsFields from '@admin/common/components/form/fields/formGroup/ContactDetailsFields';

interface OrderContactDetailsProps {
    register: UseFormRegister<OrderFormData>;
    fieldErrors: FieldErrors<OrderFormData>;
}

const OrderContactDetails: React.FC<OrderContactDetailsProps> = ({ register, fieldErrors }) => {
    return (
        <FormSection title="Informacje kontaktowe">
            <ContactDetailsFields register={register} fieldErrors={fieldErrors} />
        </FormSection>
    );
};

export default OrderContactDetails;

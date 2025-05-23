type FieldErrors = Record<string, any>;

export const hasAnyFieldError = (errors: FieldErrors, fields: string[]): boolean => {
  return fields.some(field => !!errors?.[field]);
};

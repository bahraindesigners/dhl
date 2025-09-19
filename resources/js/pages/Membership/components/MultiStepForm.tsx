import React, { useState } from 'react';
import { useTranslation } from 'react-i18next';
import { ChevronLeft, ChevronRight, Check } from 'lucide-react';

interface Step {
    id: string;
    title: string;
    component: React.ReactNode;
    isValid?: boolean;
    validate?: () => boolean;
}

interface MultiStepFormProps {
    steps: Step[];
    onSubmit: () => void;
    isSubmitting: boolean;
    isRTL: boolean;
    data: any;
    errors: Record<string, string>;
}

export default function MultiStepForm({ steps, onSubmit, isSubmitting, isRTL, data, errors }: MultiStepFormProps) {
    const { t } = useTranslation();
    const [currentStep, setCurrentStep] = useState(0);

    // Validation function for each step
    const validateStep = (stepIndex: number): boolean => {
        const step = steps[stepIndex];
        if (step.validate) {
            return step.validate();
        }
        return true;
    };

    // Check if current step is valid
    const isCurrentStepValid = (): boolean => {
        return validateStep(currentStep);
    };

    const goToNextStep = () => {
        if (currentStep < steps.length - 1 && isCurrentStepValid()) {
            setCurrentStep(currentStep + 1);
        }
    };

    const goToPreviousStep = () => {
        if (currentStep > 0) {
            setCurrentStep(currentStep - 1);
        }
    };

    const goToStep = (stepIndex: number) => {
        // Only allow navigation to previous steps or if current step is valid
        if (stepIndex <= currentStep || isCurrentStepValid()) {
            setCurrentStep(stepIndex);
        }
    };

    const isFirstStep = currentStep === 0;
    const isLastStep = currentStep === steps.length - 1;
    const currentStepData = steps[currentStep];

    return (
        <div className="max-w-4xl mx-auto">
            {/* Progress Indicator */}
            <div className="mb-8">
                <div className="flex items-center justify-between">
                    {steps.map((step, index) => (
                        <div key={step.id} className="flex items-center flex-1">
                            {/* Step Circle */}
                            <div 
                                className={`relative flex items-center justify-center w-10 h-10 rounded-full border-2 transition-all duration-200 ${
                                    index === currentStep
                                        ? 'bg-primary border-primary text-white'
                                        : index < currentStep || (index === currentStep && validateStep(index))
                                        ? 'bg-green-500 border-green-500 text-white cursor-pointer hover:bg-green-600'
                                        : 'border-gray-300 text-gray-500 cursor-not-allowed'
                                } ${
                                    index <= currentStep || validateStep(currentStep) 
                                        ? 'cursor-pointer hover:border-gray-400' 
                                        : 'cursor-not-allowed opacity-50'
                                }`}
                                onClick={() => goToStep(index)}
                            >
                                {index < currentStep || (index === currentStep && validateStep(index)) ? (
                                    <Check className="w-5 h-5" />
                                ) : (
                                    <span className="text-sm font-medium">{index + 1}</span>
                                )}
                            </div>

                            {/* Step Label */}
                            <div className={`ml-3 ${isRTL ? 'mr-3 ml-0 text-right' : ''}`}>
                                <p className={`text-sm font-medium ${
                                    index === currentStep 
                                        ? 'text-primary' 
                                        : index < currentStep 
                                        ? 'text-green-600' 
                                        : 'text-gray-500'
                                } ${isRTL ? 'font-arabic text-right' : ''}`}>
                                    {step.title}
                                </p>
                                {/* Add validation indicator */}
                                {index === currentStep && !isCurrentStepValid() && (
                                    <p className={`text-xs text-red-500 mt-1 ${isRTL ? 'font-arabic text-right' : ''}`}>
                                        {t('membership.form.fillRequiredFields')}
                                    </p>
                                )}
                            </div>

                            {/* Progress Line */}
                            {index < steps.length - 1 && (
                                <div className="flex-1 mx-4">
                                    <div className="h-0.5 bg-gray-200 relative">
                                        <div 
                                            className={`h-full transition-all duration-300 ${
                                                index < currentStep ? 'bg-green-500' : 'bg-gray-200'
                                            }`}
                                        />
                                    </div>
                                </div>
                            )}
                        </div>
                    ))}
                </div>
            </div>

            {/* Step Content */}
            <div className="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-6">
                <div className="mb-6">
                    <h2 className={`text-2xl font-bold text-gray-900 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {currentStepData.title}
                    </h2>
                    <p className={`text-gray-600 mt-2 ${isRTL ? 'font-arabic text-right' : ''}`}>
                        {t('membership.form.step')} {currentStep + 1} {t('membership.form.of')} {steps.length}
                    </p>
                </div>

                {/* Current Step Component */}
                <div className="min-h-[400px]">
                    {currentStepData.component}
                </div>
            </div>

            {/* Navigation Buttons */}
            <div className={`flex justify-between items-center ${isRTL ? 'flex-row-reverse' : ''}`}>
                {/* Previous Button */}
                <button
                    type="button"
                    onClick={goToPreviousStep}
                    disabled={isFirstStep}
                    className={`flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed ${
                        isRTL ? 'font-arabic flex-row-reverse' : ''
                    }`}
                >
                    {!isRTL ? <ChevronLeft className="w-5 h-5 mr-2" /> : null}
                    {t('membership.form.previous')}
                    {isRTL ? <ChevronLeft className="w-5 h-5 ml-2 rotate-180" /> : null}
                </button>

                {/* Step Counter */}
                <div className={`text-sm text-gray-500 ${isRTL ? 'font-arabic' : ''}`}>
                    {currentStep + 1} / {steps.length}
                </div>

                {/* Next/Submit Button */}
                {isLastStep ? (
                    <button
                        type="button"
                        onClick={onSubmit}
                        disabled={isSubmitting || !isCurrentStepValid()}
                        className={`flex items-center px-8 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed ${
                            isRTL ? 'font-arabic' : ''
                        }`}
                    >
                        {isSubmitting ? t('membership.form.submitting') : t('membership.form.submit')}
                    </button>
                ) : (
                    <button
                        type="button"
                        onClick={goToNextStep}
                        disabled={!isCurrentStepValid()}
                        className={`flex items-center px-6 py-3 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all duration-200 transform hover:scale-[1.02] disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:bg-primary ${
                            isRTL ? 'font-arabic flex-row-reverse' : ''
                        }`}
                    >
                        {t('membership.form.next')}
                        {!isRTL ? <ChevronRight className="w-5 h-5 ml-2" /> : null}
                        {isRTL ? <ChevronRight className="w-5 h-5 mr-2 rotate-180" /> : null}
                    </button>
                )}
            </div>

            {/* Error Messages Display */}
            {Object.keys(errors).length > 0 && (
                <div className="mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <div className="flex">
                        <div className="flex-shrink-0">
                            <svg className="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
                            </svg>
                        </div>
                        <div className="ml-3">
                            <h3 className={`text-sm font-medium text-red-800 ${isRTL ? 'font-arabic' : ''}`}>
                                {t('membership.form.errorsTitle')}
                            </h3>
                            <div className="mt-2 text-sm text-red-700">
                                <ul className={`list-disc space-y-1 ${isRTL ? 'list-inside font-arabic' : 'pl-5'}`}>
                                    {Object.entries(errors).map(([field, message]) => (
                                        <li key={field} className={isRTL ? 'font-arabic' : ''}>
                                            {message}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}
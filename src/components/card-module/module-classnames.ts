import { ModuleClassnamesParams, textOptionsClassnames } from '@divi/module';
import { CardModuleAttrs } from './types';

/**
 * Module classnames function for Card Module.
 *
 * @since ??
 *
 * @param {ModuleClassnamesParams<CardModuleAttrs>} param0 Function parameters.
 */
export const moduleClassnames = ({
  classnamesInstance,
  attrs,
}: ModuleClassnamesParams<CardModuleAttrs>): void => {
  // Text Options.
  classnamesInstance.add(textOptionsClassnames(attrs?.module?.advanced?.text));
};

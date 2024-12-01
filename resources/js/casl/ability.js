import { Ability } from "@casl/ability";

export const ability = new Ability([]);

export function defineRulesFor(user) {
    const rules = user.role.permissions.map((permission) => {
        const [action, subject] = permission.name.split("-");
        return { action, subject };
    });

    ability.update(rules);
    return ability;
}

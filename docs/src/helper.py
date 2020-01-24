import argparse
import yaml
import os


def setup_args():
    parser = argparse.ArgumentParser(prog='LaTeX Helper')

    parser.add_argument(
        'command',
        choices=['scenarios']
    )
    return parser.parse_args()


def list_to_string(l):
    string = ""
    for item in l:
        string += f"~~\\llap{{\\textbullet}}~~{item}\\\\"
    return string


def actions_to_string(l, current_action="", level=1):
    string = ""
    if l is None or len(l) == 0:
        return ''
    for i in range(len(l)):
        index = f"\hspace{{{0.5 * (level - 1)}cm}}{current_action}{i + 1}."
        string += f"{index} {l[i]['action']}\\\\"
        if 'subactions' in l[i]:
            string += actions_to_string(l[i]['subactions'], index, level + 1)
    return string 

def scenarios():
    with open(os.path.join(os.path.dirname(__file__), 'scenari.yml'), 'r') as f:
        data = yaml.load(f, Loader=yaml.Loader)
    if len(data) == 0:
        return

    data = sorted(data, key=lambda i: i['id'])
    content = ''
    for scenario in data:
        content += f'''\\begin{{table}}[H]
	\\centering
	\\caption{{Use Case: {scenario['usecase']}}}
	\\label{{tab:use-case-{scenario['usecase'].lower().replace(' ', '-')}}}
	\\rowcolors{{2}}{{gray!25}}{{white!0}}
	\\begin{{longtable}}{{@{{}}|>{{\\centering\\arraybackslash}}m{{.2\\textwidth}}|m{{.7\\textwidth}}|@{{}}}}
		\hline
		\\rowcolor{{emotionally-color!35}}
		{{\\textbf{{Nome caso d'uso}}}} & {{\\textbf{{{scenario['usecase']} (ID: {scenario['id']})}}}} \\\\\hline
		\\endfirsthead
		Descrizione & {scenario['description']}\\\\
		Attori & \\begin{{tabular}}{{m{{0.9\\linewidth}}}}{list_to_string(scenario['actors'])}\end{{tabular}}\\\\
		Pre-condizioni & \\begin{{tabular}}{{m{{0.9\\linewidth}}}}{list_to_string(scenario['preconditions'])}\end{{tabular}}\\\\
		Sequenza delle azioni & \\begin{{tabular}}{{m{{0.9\\linewidth}}}}{actions_to_string(scenario['actions'])}\end{{tabular}}\\\\
		Post-condizioni & \\begin{{tabular}}{{m{{0.9\\linewidth}}}}{list_to_string(scenario['postconditions'])}\end{{tabular}}\\\\
		Scenario alternativo & \\begin{{tabular}}{{m{{0.9\\linewidth}}}}{list_to_string(scenario['alternative'])}\end{{tabular}}\\\\\hline
		
	\end{{longtable}}
\end{{table}}\n\n'''
    with open(os.path.join(os.path.dirname(__file__), 'parts/documento_requisiti/_scenari.tex'), 'w') as f:
        f.write(content[:-1])


def main():
    args = setup_args()

    if args.command == 'scenarios':
        scenarios()


if __name__ == "__main__":
    main()

#!/usr/bin/env bash

OWNER_USER=`id -u`
OWNER_GROUP=`id -g`
DIRECTORY=.

while getopts ":u:g:d:h:" OPTNAME; do
	case "${OPTNAME}" in
		u)
			OWNER_USER=${OPTARG}
		;;
		g)
			OWNER_GROUP=${OPTARG}
		;;
		d)
			DIRECTORY=${OPTARG}
		;;
		h | *)
			echo "Usage: sudo $0 [-u USER] [-g GROUP] [-d DIRECTORY]"
			exit 0
		;;
	esac
done

if [[ `id -u` -ne 0 ]]; then
	echo "You are not root."
	exit 1
fi

OWNER_USER=`getent passwd "${OWNER_USER}" | awk -F: '{print $1}'`
if [[ -z ${OWNER_USER} ]]; then
	echo "Invalid user."
	exit 1
fi

OWNER_GROUP=`getent group "${OWNER_GROUP}" | awk -F: '{print $1}'`
if [[ -z ${OWNER_GROUP} ]]; then
	echo "Invalid group."
	exit 1
fi

DIRECTORY=`cd "${DIRECTORY}" 2>/dev/null && pwd -P`
if [[ -z ${DIRECTORY} ]]; then
	echo "Invalid directory."
	exit 1
fi

echo "[ --- SUMMARY --- ]"
echo "     User: ${OWNER_USER}"
echo "    Group: ${OWNER_GROUP}"
echo "Directory: ${DIRECTORY}"

echo

echo
echo "[ --- PROCESSING --- ]"
echo "Making directory '${DIRECTORY}' r/w-accessible to '${OWNER_USER}:${OWNER_GROUP}':"
{
	echo -n "- Changing ownership ... " >&15
	chown -R "${OWNER_USER}:${OWNER_GROUP}" "${DIRECTORY}"
	echo "done." >&15

	echo -n "- Changing rights to ug=rw,o=r ... " >&15
	chmod -R ug=rw,o=r "${DIRECTORY}"
	echo "done." >&15

	echo -n "- Recursively changing rights of existing directories to u=rwx,g=rwxs,o=rx ... " >&15
	find "${DIRECTORY}" -type d -exec chmod u=rwx,g=rwxs,o=rx {} \;
	echo "done." >&15

	echo -n "- Recursively changing rights of existing files to ug=rw,o=r ... " >&15
	find "${DIRECTORY}" -type f -exec chmod ug=rw,o=r {} \;
	echo "done." >&15
} 15>&1 16>&2 >/dev/null 2>&1
echo "Completed."
